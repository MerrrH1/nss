<?php

namespace App\Http\Controllers;

use App\Helpers;
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
        $salesDeliveries = SalesDeliveries::orderBy('delivery_date')->paginate(10);
        return view('sales_deliveries.index', compact('salesDeliveries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('sales_deliveries.create');
    }

    public function createSalesDelivery(SalesContract $salesContract)
    {
        $trucks = Truck::orderBy('plate_number')->get();
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
            $net_weight_kg = $request->input('gross_weight_kg') - $request->input('tare_weight_kg');
            $final_gross_weight_kg = $final_tare_weight_kg = $final_net_weight_kg = 0;
            $data = $request->merge([
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
        return view('sales_deliveries.show', compact('salesDeliveries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesDeliveries $salesDeliveries)
    {
        Log::info($salesDeliveries);
        return back();
        // return view('sales_deliveries.edit', compact('salesDeliveries'));
    }

    public function unload(SalesDeliveries $salesDelivery)
    {
        $contract = SalesContract::findOrFail($salesDelivery->sales_contract_id);
        $trucks = Truck::all();
        return view('sales_deliveries.edit', compact('salesDelivery', 'trucks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesDeliveries $salesDelivery)
    {
        $request->validate([
            'sales_contract_id' => 'required|integer|exists:sales_contracts,id',
            'truck_id' => 'required|integer|exists:trucks,id',
            'delivery_date' => 'required|date',
            'gross_weight_kg' => 'required|integer',
            'tare_weight_kg' => 'required|integer',
            'final_gross_weight_kg' => 'required|integer',
            'final_tare_weight_kg' => 'required|integer',
            'final_net_weight_kg' => 'required|integer',
            'kk_percentage' => 'nullable|decimal:0,2',
            'ka_percentage' => 'nullable|decimal:0,2',
            'ffa_percentage' => 'nullable|decimal:0,2',
            'dobi' => 'nullable|numeric',
            'claim_amount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'claim_notes' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);
        $status = "pending";
        $finalNetWeightKg = null;
        if ($request->filled('final_gross_weight_kg') && $request->filled('final_tare_weight_kg')) {
            $finalNetWeightKg = $request->input('final_gross_weight_kg') - $request->input('final_tare_weight_kg');
        }
        if (
            $request->filled('final_gross_weight_kg') && $request->filled('final_tare_weight_kg') &&
            ($request->filled('kk_percentage') || $request->filled('ka_percentage') || $request->filled('ffa_percentage') || $request->filled('dobi'))
        ) {
            $status = "completed";
        }
        $oldNetWeightKg = $salesDelivery->net_weight_kg;
        $oldFinalNetWeightKg = $salesDelivery->final_net_weight_kg;
        $newNetWeightKg = $request->input('gross_weight_kg') - $request->input('tare_weight_kg');
        $newFinalNetWeightKg = $request->input('final_gross_weight_kg') - $request->input('final_tare_weight_kg');
        $salesContract = SalesContract::find($request->input('sales_contract_id'));
        if (!$salesContract) {
            return back()->withInput()->with('error', 'Kontrak penjualan tidak ditemukan!');
        }
        // dd($request->ka_percentage + $request->kk_percentage > $salesContract->tolerated_ka_percentage + $salesContract->tolerated_kk_percentage, $request->dobi < $salesContract->tolerated_dobi_percentage && $request->dobi, $request->ffa_percentage > $salesContract->tolerated_ffa_percentage);
        if($request->ka_percentage + $request->kk_percentage > $salesContract->tolerated_ka_percentage + $salesContract->tolerated_kk_percentage || ($request->dobi < $salesContract->tolerated_dobi_percentage && $request->dobi) || $request->ffa_percentage > $salesContract->tolerated_ffa_percentage) {
            $claimAmount = $newFinalNetWeightKg * 900;
        } else {
            $claimAmount = 0;
        }
        try {
            $salesContract->update([
                'quantity_delivered_kg' => $salesContract->quantity_delivered_kg - $oldNetWeightKg + $newNetWeightKg
            ]);
            $salesDelivery->update([
                'sales_contract_id' => $request->input('sales_contract_id'),
                'delivery_date' => $request->input('delivery_date'),
                'truck_id' => $request->input('truck_id'),
                'gross_weight_kg' => (int) $request->input('gross_weight_kg'),
                'tare_weight_kg' => (int) $request->input('tare_weight_kg'),
                'net_weight_kg' => (int) $request->input('gross_weight_kg') - $request->input('tare_weight_kg'),
                'final_gross_weight_kg' => (int) $request->input('final_gross_weight_kg'),
                'final_tare_weight_kg' => (int) $request->input('final_tare_weight_kg'),
                'final_net_weight_kg' => (int) $finalNetWeightKg,
                'kk_percentage' => $request->input('kk_percentage'),
                'ka_percentage' => $request->input('ka_percentage'),
                'ffa_percentage' => $request->input('ffa_percentage'),
                'dobi' => $request->input('dobi'),
                'claim_amount' => $claimAmount,
                'total_amount' => $newFinalNetWeightKg * $salesContract->price_per_kg - $claimAmount,
                'claim_notes' => $request->input('claim_notes'),
                'notes' => $request->input('notes'),
                'status' => $status,
            ]);
            if (SalesDeliveries::where('sales_contract_id', '=', $salesDelivery->sales_contract_id)->where('status', '!=', 'pending')->count() == SalesDeliveries::where('sales_contract_id', '=', $salesDelivery->sales_contract_id)->count()) {
                $contract = SalesContract::where('id', '=', $salesDelivery->sales_contract_id);
                $contract->update(['status' => 'completed']);
            }
            return redirect()->route('sales_contracts.show', $salesContract)->with('success', 'Pengiriman penjualan berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui pengiriman penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengiriman penjualan!');
        }
    }

    public function cancel(SalesDeliveries $salesDelivery)
    {
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
