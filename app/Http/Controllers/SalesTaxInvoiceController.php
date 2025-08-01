<?php

namespace App\Http\Controllers;

use App\Models\SalesTaxInvoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SalesTaxInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesTaxInvoices = SalesTaxInvoice::orderBy('created_at')->paginate(10);
        return view('sales_tax_invoices.index', compact('salesTaxInvoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales_tax_invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sales_invoice_id' => 'required|integer',
            'tax_invoice_number' => 'required|string|max:2',
            'tax_invoice_date' => 'required|date',
            'dpp_amount' => 'required|decimal',
            'ppn_amount' => 'required|decimal',
            'payment_status' => 'required|enum:paid,unpaid',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        try {
            SalesTaxInvoice::create($request->all());
            return redirect()->route('sales_tax_invoices.index')->with('success', 'Faktur pajak penjualan berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan faktur pajak penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan faktur pajak penjualan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesTaxInvoice $salesTaxInvoice)
    {
        return view('sales_tax_invoices.show', compact('salesTaxInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesTaxInvoice $salesTaxInvoice)
    {
        return view('sales_tax_invoices.edit', compact('salesTaxInvoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesTaxInvoice $salesTaxInvoice)
    {
        $request->validate([
            'sales_invoice_id' => 'required|integer',
            'tax_invoice_number' => 'required|string|max:2',
            'tax_invoice_date' => 'required|date',
            'dpp_amount' => 'required|decimal',
            'ppn_amount' => 'required|decimal',
            'payment_status' => 'required|enum:paid,unpaid',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        try {
            SalesTaxInvoice::update($request->all());
            return redirect()->route('sales_tax_invoices.index')->with('success', 'Faktur pajak penjualan berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui faktur pajak penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui faktur pajak penjualan!');
        }
    }

    public function markAsPaid(Request $request, SalesTaxInvoice $salesTaxInvoice)
    {
        // Prevent marking as paid if it's already paid
        if ($salesTaxInvoice->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Faktur Pajak ini sudah ditandai sebagai sudah dibayar sebelumnya.');
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

        // Update payment_date and payment_status
        $salesTaxInvoice->payment_date = $request->input('payment_date');
        $salesTaxInvoice->payment_status = 'paid'; // Explicitly set status to 'paid'
        $salesTaxInvoice->save();

        return redirect()->back()->with('success', 'Faktur Pajak berhasil ditandai sebagai sudah dibayar!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesTaxInvoice $salesTaxInvoice)
    {
        try {
            $salesTaxInvoice->delete();
            return redirect()->route('sales_tax_invoices.index')->with('success', 'Faktur pajak penjualan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus faktur pajak penjualan: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('sales_tax_invoices.index')->with('error', 'Terjadi kesalahan saat menghapus faktur pajak penjualan!');
        }
    }
}
