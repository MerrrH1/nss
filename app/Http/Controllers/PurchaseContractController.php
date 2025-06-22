<?php

namespace App\Http\Controllers;

use App\Models\PurchaseContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PurchaseContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseContracts = PurchaseContract::orderBy('created_at')->paginate(10);
        return view('purchase_contracts.index', compact('purchaseContracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase_contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'contract_number' => 'required|string|max:255|unique:purchase_contracts,contract_number',
            'contract_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'commodity_id' => 'required|integer',
            'total_quantity_kg' => 'required|decimal',
            'price_per_kg' => 'required|decimal',
            'tolerated_kk_percentage' => 'nullable|decimal',
            'tolerated_ka_percentage' => 'nullable|decimal',
            'tolerated_ffa_percentage' => 'nullable|decimal',
            'quantity_received_kg' => 'nullable|decimal',
            'status' => 'nullable|enum:active,completed,canceled',
            'notes' => 'nullable|string'
        ]);

        try {
            PurchaseContract::create($request->all());
            return redirect()->route('purchase_contracts.index')->with('success', 'Kontrak pembelian berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan kontrak pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan kontrak pembelian!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseContract $purchaseContract)
    {
        return view('purchase_contracts.show', compact('purchase_contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseContract $purchaseContract)
    {
        return view('purchase_contracts.edit', compact('purchase_contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseContract $purchaseContract)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'contract_number' => 'required|string|max:255|' . Rule::unique('purchase_contracts')->ignore($purchaseContract->id()),
            'contract_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'commodity_id' => 'required|integer',
            'total_quantity_kg' => 'required|decimal',
            'price_per_kg' => 'required|decimal',
            'tolerated_kk_percentage' => 'nullable|decimal',
            'tolerated_ka_percentage' => 'nullable|decimal',
            'tolerated_ffa_percentage' => 'nullable|decimal',
            'quantity_received_kg' => 'nullable|decimal',
            'status' => 'nullable|enum:active,completed,canceled',
            'notes' => 'nullable|string'
        ]);

        try {
            PurchaseContract::create($request->all());
            return redirect()->route('purchase_contracts.index')->with('success', 'Kontrak pembelian berhasil ditambahkan!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menambahkan kontrak pembelian: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan kontrak pembelian!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseContract $purchaseContract)
    {
        try {
            $purchaseContract->delete();
            return redirect()->route('purchase_contracts.index')->with('success', 'Kontrak pembelian berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus kontrak pembelian: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('purchase_contracts.index')->with('error', 'Terjadi kesalahan saat menghapus kontrak pembelian!');
        }
    }
}
