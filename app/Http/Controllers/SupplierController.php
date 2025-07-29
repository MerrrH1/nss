<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:suppliers,email',
            'npwp' => 'nullable|string|max:20|unique:suppliers,npwp',
        ]);

        try {
            Supplier::create($request->all());
            return redirect()->route('suppliers.index')->with('success', 'Penjual berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan penjual: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan penjual!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,id,' . $supplier->id ,
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:suppliers,email',
            'npwp' => 'nullable|string|max:20|unique:suppliers,id,' . $supplier->npwp
        ]);

        try {
            $supplier->update($request->all());
            return redirect()->route('suppliers.index')->with('success', 'Penjual berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui penjual: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui penjual!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('success', 'Penjual berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus penjual: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('suppliers.index')->with('error', 'Terjadi kesalahan saat menghapus penjual!');
        }
    }
}
