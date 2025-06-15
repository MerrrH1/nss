<?php

namespace App\Http\Controllers;

use App\Models\PurchaseTaxInvoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseTaxInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseTaxInvoices = PurchaseTaxInvoice::orderBy('created_at')->paginate(10);
        return view('purchase_tax_invoices.index', compact('purchase_tax_invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase_tax_invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchase_invoice_id' => 'required|integer',
            'tax_invoice_number' => 'required|string|max:2',
            'tax_invoice_date' => 'required|date',
            'dpp_amount' => 'required|decimal',
            'ppn_amount' => 'required|decimal',
            'payment_status' => 'required|enum:paid,unpaid',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        try {
            PurchaseTaxInvoice::create($request->all());
            return redirect()->route('purchase_tax_invoices.index')->with('success', 'Faktur pajak pembelian berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan faktur pajak pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan faktur pajak pembelian!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseTaxInvoice $purchaseTaxInvoice)
    {
        return view('purchase_tax_invoices.show', compact('purchase_tax_invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseTaxInvoice $purchaseTaxInvoice)
    {
        return view('purchase_tax_invoices.edit', compact('purchase_tax_invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseTaxInvoice $purchaseTaxInvoice)
    {
        $request->validate([
            'purchase_invoice_id' => 'required|integer',
            'tax_invoice_number' => 'required|string|max:2',
            'tax_invoice_date' => 'required|date',
            'dpp_amount' => 'required|decimal',
            'ppn_amount' => 'required|decimal',
            'payment_status' => 'required|enum:paid,unpaid',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        try {
            PurchaseTaxInvoice::update($request->all());
            return redirect()->route('purchase_tax_invoices.index')->with('success', 'Faktur pajak pembelian berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui faktur pajak pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui faktur pajak pembelian!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseTaxInvoice $purchaseTaxInvoice)
    {
        try {
            $purchaseTaxInvoice->delete();
            return redirect()->route('purchase_tax_invoices.index')->with('success', 'Faktur pajak pembelian berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus faktur pajak pembelian: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('purchase_tax_invoices.index')->with('error', 'Terjadi kesalahan saat menghapus faktur pajak pembelian!');
        }
    }
}
