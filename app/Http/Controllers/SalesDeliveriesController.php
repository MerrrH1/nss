<?php

namespace App\Http\Controllers;

use App\Models\SalesContract;
use App\Models\SalesDeliveries;
use App\Models\Truck;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        // return view('sales_deliveries.create');
    }

    public function createSalesDelivery(SalesContract $salesContract) {
        $trucks = Truck::all();
        return view('sales_deliveries.create', compact('salesContract', 'trucks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sales_contract_id' => 'required|integer',
            'truck_id' => 'required|integer',
            'delivery_date' => 'required|date',
            'gross_weight_kg' => 'required|numeric',
            'tare_weight_kg' => 'required|numeric',
            'notes' => 'nullable|string'
        ]);

        try {
            $delivery_number = $this->createDeliveryNumber($request->delivery_date);
            $net_weight_kg = $request->input('gross_weight_kg') - $request->input('tare_weight_kg');
            $final_gross_weight_kg = $final_tare_weight_kg = $final_net_weight_kg = 0;
            $data = $request->merge([
                'delivery_number' => $delivery_number,
                'net_weight_kg' => $net_weight_kg,
                'final_gross_weight_kg' => $final_gross_weight_kg,
                'final_tare_weight_kg' => $final_tare_weight_kg,
                'final_net_weight_kg' => $final_net_weight_kg,
                'status' => 'pending'
            ])->all();

            SalesDeliveries::create($data);
            $salesContract = SalesContract::findOrFail($request->input('sales_contract_id'));
            if ($salesContract) {
                $salesContract->update(['quantity_delivered_kg' => $salesContract->quantity_delivered_kg += $net_weight_kg]);
            }
            return redirect()->route('sales_contracts.show', $request->input('sales_contract_id'))->with('success', 'Pengiriman penjualan berhasil ditambahkan!');
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
        return view('sales_deliveries.edit', compact('salesDeliveries'));
    }

    public function createDeliveryNumber($date) {
        $prefix = "MT";
        $today = Carbon::parse($date)->format('Ymd');
        $companyCode = "NSS";

        $countDelivery = SalesDeliveries::whereDate('delivery_date', '=', $date)->count();
        if ($countDelivery > 0) {
            $nextNumber = str_pad($countDelivery + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = "001";
        }
        $generatedCode = "{$prefix}/{$today}/{$companyCode}/{$nextNumber}";
        return $generatedCode;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesDeliveries $salesDeliveries)
    {
        $request->validate([
            'sales_contract_id' => 'required|integer',
            'truck_id' => 'required|integer',
            'delivery_number' => 'required|string|max:255|unique:sales_deliveries,delivery_number,' . $salesDeliveries->id,
            'delivery_date' => 'required|date',
            'gross_weight_kg' => 'required|numeric',
            'tare_weight_kg' => 'required|numeric',
            'kk_percentage' => 'required|decimal:0,2',
            'ka_percentage' => 'required|decimal:0,2',
            'ffa_percentage' => 'required|decimal:0,2',
            'claim_amount' => 'required|decimal',
            'total_amount' => 'required|decimal',
            'claim_notes' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        try {
            $net_weight_kg = $request->input('gross_weight_kg') - $request->input('tare_weight_kg');
            $final_gross_weight_kg = $final_tare_weight_kg = $final_net_weight_kg = 0;
            $data = $request->merge([
                'net_weight_kg' => $net_weight_kg,
                'final_gross_weight_kg' => $final_gross_weight_kg,
                'final_tare_weight_kg' => $final_tare_weight_kg,
                'final_net_weight_kg' => $final_net_weight_kg,
                'status' => 'pending'
            ])->all();

            SalesDeliveries::update($data);
            return redirect()->route('sales_deliveries.index')->with('success', 'Pengiriman penjualan berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui pengiriman penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengiriman penjualan!');
        }
    }

    public function cancel(SalesDeliveries $salesDelivery) {
        $contract = SalesContract::findOrFail($salesDelivery->sales_contract_id);
        $contract->update(['quantity_delivered_kg' => $contract->quantity_delivered_kg - $salesDelivery->net_weight_kg]);
        $salesDelivery->update(['status' => 'cancelled']);
        return back()->with("Pengiriman penjualan berhasil ditolak!");
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
