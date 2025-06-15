<?php

namespace App\Http\Controllers;

use App\Models\SalesContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SalesContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesContracts = SalesContract::orderBy('created_at')->paginate(10);
        return view('sales_contracts.index', compact('sales_contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales_contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contract_number' => 'required|string|max:255|unique:sales_contracts,contract_number',
            'buyer_id' => 'required|integer',
            'commodity_id' => 'required|integer',
            'contract_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
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
            SalesContract::create($request->all());
            return redirect()->route('sales_contracts.index')->with('success', 'Kontrak penjualan berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan kontrak penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan kontrak penjualan!');
        
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesContract $salesContract)
    {
        return view('sales_contracts.index', compact('salesContract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesContract $salesContract)
    {
        return view('sales_contracts.index', compact('salesContract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesContract $salesContract)
    {
        $request->validate([
            'contract_number' => 'required|string|max:255|' . Rule::unique('contract_number')->ignore($salesContract->id),
            'buyer_id' => 'required|integer',
            'commodity_id' => 'required|integer',
            'contract_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
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
            SalesContract::update($request->all());
            return redirect()->route('sales_contracts.index')->with('success', 'Kontrak penjualan berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui kontrak penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui kontrak penjualan!');
        
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesContract $salesContract)
    {
        try {
            $salesContract->delete();
            return redirect()->route('sales_contracts.index')->with('success', 'Kontrak penjualan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus kontrak penjualan: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('sales_contracts.index')->with('error', 'Terjadi kesalahan saat menghapus kontrak penjualan!');
        }
    }
}
