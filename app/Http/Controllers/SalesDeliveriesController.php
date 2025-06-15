<?php

namespace App\Http\Controllers;

use App\Models\SalesDeliveries;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SalesDeliveriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesDeliveries = SalesDeliveries::orderBy('created_at')->paginate(10);
        return view('sales_deliveries.index', compact('sales_deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales_deliveries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sales_contract_id' => 'required|integer',
            'truck_id' => 'required|integer',
            'delivery_number' => 'required|string|max:255|unique:sales_deliveries,delivery_number',
            'delivery_date' => 'required|date',
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
            SalesDeliveries::create($request->all());
            return redirect()->route('sales_deliveries.index')->with('success', 'Pengiriman penjualan berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan pengiriman penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan pengiriman penjualan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesDeliveries $salesDeliveries)
    {
        return view('sales_deliveries.show', compact('sales_deliveries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesDeliveries $salesDeliveries)
    {
        return view('sales_deliveries.edit', compact('sales_deliveries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesDeliveries $salesDeliveries)
    {
        $request->validate([
            'sales_contract_id' => 'required|integer',
            'truck_id' => 'required|integer',
            'delivery_number' => 'required|string|max:255|' . Rule::unique('sales_deliveries')->ignore($salesDeliveries->id()),
            'delivery_date' => 'required|date',
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
            SalesDeliveries::update($request->all());
            return redirect()->route('sales_deliveries.index')->with('success', 'Pengiriman penjualan berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui pengiriman penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengiriman penjualan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesDeliveries $salesDeliveries)
    {
        try {
            $salesDeliveries->delete();
            return redirect()->route('sales_deliveries.index')->with('Pengiriman penjualan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus pengiriman penjualan: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('sales_deliveries.index')->with('Terjadi kesalahan saat menghapus pengiriman penjualan!');
        }
    }
}
