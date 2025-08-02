<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\PurchaseContract;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        $suppliers = Supplier::orderBy('name')->get();
        $commodities = Commodity::orderBy('name')->get();
        return view('purchase_contracts.create', compact('suppliers', 'commodities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'supplier_id' => ['required', 'exists:suppliers,id'],
                'contract_number' => ['required', 'string', 'max:255', 'unique:purchaseContracts,contract_number'],
                'contract_date' => ['required', 'date'],
                'commodity_id' => ['required', 'exists:commodities,id'],
                'total_quantity_kg' => ['required', 'numeric', 'min:0'],
                'price_per_kg' => ['required', 'numeric', 'min:0'],
                'tolerated_kk_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'tolerated_ka_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'tolerated_ffa_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'tolerated_dobi_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'notes' => ['nullable', 'string', 'max:1000'],
            ], [
                'supplier_id.required' => 'Pemasok wajib dipilih.',
                'contract_number.required' => 'Nomor kontrak wajib diisi.',
                'contract_number.unique' => 'Nomor kontrak ini sudah digunakan.',
                'commodity_id.required' => 'Komoditas wajib dipilih.',
                'total_quantity_kg.required' => 'Total Kuantitas (Kg) wajib diisi.',
                'price_per_kg.required' => 'Harga Per Kg wajib diisi.',
            ]);
            $validatedData['quantity_received_kg'] = 0;
            $validatedData['status'] = 'active';

            PurchaseContract::create($validatedData);

            return redirect()->route('purchase_contracts.index')->with('success', 'Kontrak Pembelian berhasil dibuat!');

        } catch (ValidationException $e) {
            Log::error($e);
            return redirect()->back()->withErrors($e->validator->getMessageBag())->withInput();
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan Kontrak Pembelian: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseContract $purchaseContract)
    {
        return view('purchase_contracts.show', compact('purchaseContract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseContract $purchaseContract)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $commodities = Commodity::orderBy('name')->get();
        return view('purchase_contracts.edit', compact('purchaseContract', 'suppliers', 'commodities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseContract $purchaseContract)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'contract_number' => 'required|string|max:255|' . Rule::unique('purchaseContracts')->ignore($purchaseContract->id()),
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
