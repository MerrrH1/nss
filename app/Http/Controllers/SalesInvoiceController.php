<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesInvoices = SalesInvoice::orderBy('name')->paginate(10);
        return view('sales_invoices.index', compact('salesInvoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales_invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255|unique:sales_invoices,invoice_number',
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
            SalesInvoice::create($request->all());
            return redirect()->route('sales_invoices.index')->with('Faktur penjualan berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan faktur penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan faktur penjualan!');
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
