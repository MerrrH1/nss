<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Commodity;
use App\Models\SalesContract;
use App\Models\SalesDeliveries;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $salesContracts = SalesContract::query()->with(['buyer', 'salesDeliveries', 'salesInvoices']);
        // $salesContracts->where(function($query) {
        //     $query->where('payment_term', '=', 'dp50')->whereDoesntHave('salesInvoices');
        //     $query->orWhere(function($q) {
        //         $q->where('payment_term', '=', 'bulk_payment')->whereHas('salesDeliveries', function($deliveryQuery) {
        //             $deliveryQuery->where('status', '=', 'completed')->whereNull('sales_invoice_id');
        //         })->orWhereDoesntHave('salesDeliveries', function($deliveryQuery) {
        //             $deliveryQuery->where('status', '=', 'completed');
        //         });
                
        //     });
        // });
        $salesContracts = SalesContract::orderBy('contract_date')->paginate(10);
        // $salesContracts = SalesContract::whereRelation('salesInvoices', 'id', '=', '2')->orderBy('contract_date')->paginate(10);
        // $salesContracts = SalesContract::join('sales_deliveries', 'sales_deliveries.sales_contract_id', '=', 'sales_contracts.id')->whereDoesntHave('salesInvoices')->paginate(10);
        return view('sales_contracts.index', compact('salesContracts'));
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
            'contract_number' => 'nullable|max:255|unique:sales_contracts,contract_number',
            'buyer_id' => 'required|integer',
            'commodity_id' => 'required|integer',
            'contract_date' => 'required|date',
            'total_quantity_kg' => 'required|numeric|min:0',
            'price_per_kg' => 'required|numeric|min:0',
            'tolerated_kk_percentage' => 'nullable|numeric|min:0|max:100',
            'tolerated_ka_percentage' => 'nullable|numeric|min:0|max:100',
            'tolerated_ffa_percentage' => 'nullable|numeric|min:0|max:100',
            'quantity_delivered_kg' => 'nullable|numeric|min:0',
            'payment_term' => 'required',
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

        $totalSalesByContract = SalesDeliveries::where('sales_contract_id', '=', $salesContract->id)->sum('total_amount');
        $totalUnloadQuantity = SalesDeliveries::where('sales_contract_id', '=', $salesContract->id)->sum('final_net_weight_kg');
        return view('sales_contracts.show', compact('salesContract', 'totalSalesByContract', 'totalUnloadQuantity'));
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
            'payment_term' => 'required',
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

    public function closeContract(SalesContract $salesContract)
    {
        try {
            $salesContract->update(['status' => 'completed']);
            return back()->with('success', 'Kontrak penjualan berhasil ditutup di ' . number_format($salesContract->quantity_delivered_kg) . ' kg!');
        } catch (Exception $e) {
            Log::error("Gagal menutup kontrak penjualan: {$e->getMessage()}", ['exception' => $e]);
            return back()->with('error', 'Terjadi kesalahan saat menutup kontrak penjualan!');
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
