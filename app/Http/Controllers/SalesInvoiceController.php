<?php

namespace App\Http\Controllers;

use App\Models\SalesContract;
use App\Models\SalesDeliveries;
use App\Models\SalesInvoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesInvoices = SalesInvoice::orderBy('payment_date')
            ->orderBy('invoice_date', 'DESC')->paginate(10);
        return view('sales_invoices.index', compact('salesInvoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('sales_invoices.create');
    }

    public function createSalesInvoice(SalesContract $salesContract)
    {
        $invoiceType = '';
        $suggestedAmount = 0;
        $totalContractValue = $salesContract->total_quantity_kg * $salesContract->price_per_kg;

        if ($salesContract->payment_term == 'dp50') {
            if ($salesContract->salesInvoices->count() == 0) {
                $invoiceType = 'dp';
                $suggestedAmount = $totalContractValue * 0.50; // 50% untuk DP
            } elseif ($salesContract->salesInvoices->count() == 1) {
                $invoiceType = 'pelunasan';
                // Hitung sisa yang belum di-invoice
                $totalInvoicedAmount = $salesContract->salesInvoices->sum('amount');
                $suggestedAmount = $totalContractValue - $totalInvoicedAmount;
            } else {
                // Seharusnya tidak terjadi jika logika di frontend benar,
                // atau kontrak sudah lunas
                return redirect()->back()->with('error', 'Kontrak ini sudah memiliki invoice yang lengkap.');
            }
        } elseif ($salesContract->payment_term == 'bulk_payment') {
            $invoiceType = 'bulk'; // Untuk invoice per pengiriman/kuantitas
            // Tidak ada suggestedAmount spesifik karena tergantung kuantitas yang di-invoice
        } else { // '100_percent_after_completion'
            // Logika untuk invoice 100% setelah selesai
            if ($salesContract->salesInvoices->count() == 0 && $salesContract->status == 'completed') {
                $invoiceType = 'full_payment';
                $suggestedAmount = $totalContractValue;
            } else {
                return redirect()->back()->with('error', 'Invoice 100% hanya bisa dibuat setelah kontrak selesai dan belum ada invoice.');
            }
        }

        return view('sales_invoices.create', compact('salesContract', 'invoiceType', 'suggestedAmount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $salesContract = SalesContract::findOrFail($request->sales_contract_id);

        // --- VALIDASI ---
        $validatedData = $request->validate([
            'sales_contract_id' => 'required|integer|exists:sales_contracts,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'sub_total' => 'required|numeric|min:0', // Menggunakan nama field dari hidden input
            'tax_amount' => 'required|numeric|min:0', // Menggunakan nama field dari hidden input
            'total_amount' => 'required|numeric|min:0', // Menggunakan nama field dari hidden input
            'notes' => 'nullable|string|max:1000',
            // Validasi untuk selected_deliveries hanya jika payment_term adalah bulk_payment
            'selected_deliveries' => ($salesContract->payment_term === 'bulk_payment') ? 'required|array|min:1' : 'nullable|array',
            'selected_deliveries.*' => 'integer|exists:sales_deliveries,id',
        ]);

        DB::beginTransaction();
        Log::info("Transaksi pembuatan invoice dimulai untuk kontrak ID: {$salesContract->id}");

        try {
            // --- GENERATE INVOICE NUMBER ---
            // Logika untuk invoice_number: Anda bisa menggunakan paket seperti `spatie/laravel-sluggable` atau logika manual
            $latestInvoice = SalesInvoice::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->orderBy('id', 'desc')
                ->first();
            $counter = $latestInvoice ? (int)substr($latestInvoice->invoice_number, -4) + 1 : 1;
            $invoiceNumber = 'INV-' . $salesContract->contract_number . '-' . date('Ym') . sprintf('%04d', $counter);

            // Periksa keunikan invoice_number sebelum membuat
            if (SalesInvoice::where('invoice_number', $invoiceNumber)->exists()) {
                // Jika nomor invoice yang digenerate sudah ada, coba lagi atau tambahkan logika penanganan
                // Misalnya, tambahkan suffix atau re-generate
                $invoiceNumber .= '-DUP-' . Str::random(4); // Contoh penanganan duplikat sederhana
                Log::warning("Nomor invoice {$invoiceNumber} duplikat, generate ulang.");
            }

            $invoiceData = [
                'sales_contract_id' => $salesContract->id, // Pastikan sales_contract_id juga masuk
                'invoice_number' => $invoiceNumber, // Gunakan nomor yang digenerate
                'invoice_date' => $validatedData['invoice_date'],
                'due_date' => $validatedData['due_date'],
                'sub_total' => $validatedData['sub_total'],
                'tax_amount' => $validatedData['tax_amount'],
                'total_amount' => $validatedData['total_amount'],
                'payment_status' => 'pending', // Default status saat invoice dibuat
                'payment_date' => null, // Default null saat invoice dibuat, diisi saat lunas
                'notes' => $validatedData['notes'] ?? null,
            ];

            $invoice = SalesInvoice::create($invoiceData);
            Log::info("Invoice baru dibuat dengan ID: {$invoice->id}, Nomor: {$invoice->invoice_number}");

            // --- LAMPIRKAN PENGIRIMAN UNTUK BULK PAYMENT ---
            if ($salesContract->payment_term == "bulk_payment" && isset($validatedData['selected_deliveries'])) {
                // Gunakan model singular: SalesDelivery
                Log::info("Satu");
                $selectedDeliveries = SalesDeliveries::whereIn('id', $validatedData['selected_deliveries'])
                    ->where('sales_contract_id', $salesContract->id)
                    ->where('status', 'completed')
                    ->whereDoesntHave('salesInvoices')
                    ->pluck('id');
                Log::info("Dua");

                if ($selectedDeliveries->isEmpty()) {
                    DB::rollBack();
                    Log::warning("Gagal membuat invoice: Tidak ada pengiriman valid yang dipilih atau sudah ter-invoice.", ['contract_id' => $salesContract->id, 'selected_deliveries' => $validatedData['selected_deliveries']]);
                    return back()->withInput()->with('error', 'Tidak ada pengiriman selesai yang valid untuk di-invoice atau sudah ter-invoice!');
                }

                $invoice->salesDeliveries()->attach($selectedDeliveries);
                Log::info("Pengiriman dilampirkan ke invoice {$invoice->id}: " . json_encode($selectedDeliveries->toArray()));
            }

            DB::commit();
            Log::info("Invoice {$invoice->id} berhasil disimpan dan transaksi di-commit.");
            return redirect()->route('sales_invoices.show', $invoice->id)->with('success', 'Invoice Penjualan berhasil dibuat!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal menambahkan invoice penjualan: {$e->getMessage()}", [
                'exception' => $e,
                'request_data' => $request->all(),
                'contract_id' => $salesContract->id ?? 'N/A'
            ]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan invoice penjualan! Silakan periksa log.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesInvoice $salesInvoice)
    {
        return view('sales_invoices.show', compact('salesInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoice $salesInvoice)
    {
        return view('sales_invoices.edit', compact('salesInvoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesInvoice $salesInvoice)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255|' . Rule::unique('sales_invoices')->ignore($salesInvoice->id),
            'sales_contract_id' => 'required|integer',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'sub_total' => 'required|decimal',
            'tax_amount' => 'required|decimal',
            'total_amount' => 'required|decimal',
            'payment_status' => 'required|enum:paid,unpaid',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        try {
            SalesInvoice::update($request->all());
            return redirect()->route('sales_invoices.index')->with('Faktur penjualan berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui faktur penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui faktur penjualan!');
        }
    }

    public function markAsPaid(Request $request, SalesInvoice $salesInvoice)
    {
        if ($salesInvoice->payment_date !== null) {
            return redirect()->back()->with('error', 'Invoice ini sudah ditandai sebagai sudah dibayar sebelumnya.');
        }

        try {
            $request->validate([
                'payment_date' => ['required', 'date', 'before_or_equal:today'],
            ], [
                'payment_date.required' => 'Tanggal pembayaran wajib diisi.',
                'payment_date.date' => 'Tanggal pembayaran harus berupa tanggal yang valid.',
                'payment_date.before_or_equal' => 'Tanggal pembayaran tidak boleh di masa depan.',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $salesInvoice->payment_date = $request->input('payment_date');
        $salesInvoice->save();

        return redirect()->back()->with('success', 'Invoice berhasil ditandai sebagai sudah dibayar!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoice $salesInvoice)
    {
        try {
            $salesInvoice->delete();
            return redirect()->route('sales_invoices.index')->with('success', 'Faktur penjualan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus faktur penjualan: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('sales_invoices.index')->with('error', 'Terjadi kesalahan saat menghapus faktur penjualan!');
        }
    }
}
