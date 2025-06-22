<?php

namespace App\Http\Controllers;

use App\Enums\SalesContractStatus;
use App\Models\Buyer;
use App\Models\Commodity;
use App\Models\SalesContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;

class SalesContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesContracts = SalesContract::orderBy('contract_date')->paginate(10);
        $buyers = Buyer::all();
        $commodities = Commodity::all();
        return view('sales_contracts.index', compact('salesContracts', 'buyers', 'commodities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buyers = Buyer::all();
        $commodities = Commodity::all();
        return view('sales_contracts.create', compact('buyers', 'commodities'));
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
            'total_quantity_kg' => 'required|numeric|min:0',
            'price_per_kg' => 'required|numeric|min:0',
            'tolerated_kk_percentage' => 'nullable|numeric|min:0|max:100',
            'tolerated_ka_percentage' => 'nullable|numeric|min:0|max:100',
            'tolerated_ffa_percentage' => 'nullable|numeric|min:0|max:100',
            'quantity_delivered_kg' => 'nullable|numeric|min:0',
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
        return view('sales_contracts.show', compact('salesContract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesContract $salesContract)
    {
        $buyers = Buyer::all();
        $commodities = Commodity::all();
        return view('sales_contracts.edit', compact('salesContract', 'buyers', 'commodities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesContract $salesContract)
    {
        $request->validate([
            'contract_number' => 'required|string|max:255|unique:sales_contracts,contract_number,' . $salesContract->id,
            'buyer_id' => 'required|integer',
            'commodity_id' => 'required|integer',
            'contract_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'total_quantity_kg' => 'required|numeric|min:0',
            'tolerated_kk_percentage' => 'nullable|numeric|min:0|max:0',
            'tolerated_ka_percentage' => 'nullable|numeric|min:0|max:0',
            'tolerated_ffa_percentage' => 'nullable|numeric|min:0|max:0',
            'quantity_received_kg' => 'nullable|numeric|min:0|max:0',
            'notes' => 'nullable|string'
        ]);

        try {
            $salesContract->update($request->all());
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
