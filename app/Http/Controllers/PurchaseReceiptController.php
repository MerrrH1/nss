<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReceipt;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PurchaseReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseReceipts = PurchaseReceipt::orderBy('created_at')->paginate(10);
        return view('purchase_receipts.index', compact('purchase_receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase_receipts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchase_contract_id' => 'required|integer',
            'truck_id' => 'required|integer',
            'receipt_number' => 'required|string|max:255|unique:purchase_receipts,receipt_number',
            'receipt_date' => 'required|date',
            'gross_weight_kg' => 'required|decimal',
            'tare_weight_kg' => 'required|decimal',
            'net_weight_kg' => 'required|decimal',
            'final_gross_weight_kg' => 'required|decimal',
            'final_tare_weight_kg' => 'required|decimal',
            'final_net_weight_kg' => 'required|decimal',
            'kk_percentage' => 'required|decimal',
            'ka_percentage' => 'required|decimal',
            'ffa_percentage' => 'required|decimal',
            'price_per_kg' => 'required|decimal',
            'claim_amount' => 'required|decimal',
            'total_amount' => 'required|decimal',
            'claim_notes' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        try {
            PurchaseReceipt::create($request->all());
            return redirect()->route('purchase_receipts.index')->with('success', 'Penerimaan pembelian berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan penerimaan pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan penerimaan pembelian!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseReceipt $purchaseReceipt)
    {
        return view('puchase_receipts.show', compact('purchaseReceipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseReceipt $purchaseReceipt)
    {
        return view('puchase_receipts.edit', compact('puchaseReceipt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $request->validate([
            'purchase_contract_id' => 'required|integer',
            'truck_id' => 'required|integer',
            'receipt_number' => 'required|string|max:255|' . Rule::unique('purchase_receipts')->ignore($purchaseReceipt->id),
            'receipt_date' => 'required|date',
            'gross_weight_kg' => 'required|decimal',
            'tare_weight_kg' => 'required|decimal',
            'net_weight_kg' => 'required|decimal',
            'final_gross_weight_kg' => 'required|decimal',
            'final_tare_weight_kg' => 'required|decimal',
            'final_net_weight_kg' => 'required|decimal',
            'kk_percentage' => 'required|decimal',
            'ka_percentage' => 'required|decimal',
            'ffa_percentage' => 'required|decimal',
            'price_per_kg' => 'required|decimal',
            'claim_amount' => 'required|decimal',
            'total_amount' => 'required|decimal',
            'claim_notes' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        try {
            PurchaseReceipt::update($request->all());
            return redirect()->route('purchase_receipts.index')->with('success', 'Penerimaan pembelian berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui penerimaan pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui penerimaan pembelian!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseReceipt $purchaseReceipt)
    {
        try {
            $purchaseReceipt->delete();
            return redirect()->route('purchase_receipts.index')->with('success', 'Penerimaan pembelian berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus penerimaan pembelian: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('purchase_receipts.index')->with('error', 'Terjadi kesalahan saat menghapus penerimaan pembelian!');
        }
    }
}
