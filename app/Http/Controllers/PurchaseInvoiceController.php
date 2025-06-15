<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseInvoices = PurchaseInvoice::orderBy('created_at')->paginate(10);
        return view('purchase_invoices.index', compact('purchase_invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase_invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255|unique:purchase_invoices,invoice_number',
            'purchase_contract_id' => 'required|integer',
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
            PurchaseInvoice::create($request->all());
            return redirect()->route('purchase_invoices.index')->with('success', 'Faktur pembelian berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan faktur pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan faktur pembelian!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        return view('purchase_invoices.show', compact('purchase_invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        return view('purchase_invoices.edit', compact('purchase_invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255|' . Rule::unique('purchase_invoices')->ignore($purchaseInvoice->id()),
            'purchase_contract_id' => 'required|integer',
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
            PurchaseInvoice::create($request->all());
            return redirect()->route('purchase_invoices.index')->with('success', 'Faktur pembelian berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan faktur pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan faktur pembelian!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        try {
            $purchaseInvoice->delete();
            return redirect()->route('purchase_invoices.index')->with('success', 'Faktur pembelian berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus faktur pembelian: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('purchase_invoices.index')->with('error', 'Terjadi kesalahan saat menghapus faktur pembelian!');
        }
    }
}
