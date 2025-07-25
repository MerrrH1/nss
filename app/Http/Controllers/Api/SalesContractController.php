<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesContract;
use App\Models\SalesDeliveries;
use Illuminate\Http\Request;

class SalesContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesContracts = SalesDeliveries::join('sales_contracts', 'sales_contracts.id' , '=', 'sales_deliveries.sales_contract_id')->get();
        return response()->json($salesContracts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesContract $salesContract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesContract $salesContract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesContract $salesContract)
    {
        //
    }
}
