<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodities = Commodity::orderBy('name')->paginate(10);
        return view('commodities.index', compact('commodities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commodities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:commodities,name',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            Commodity::create($request->all());
            return redirect()->route('commodities.index')->with('success', 'Barang berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan barang: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan barang!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Commodity $commodity)
    {
        return view('commodities.show', compact('commodity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commodity $commodity)
    {
        return view('commodities.edit', compact('commodity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commodity $commodity)
    {
        $request->validate([
            'name' => 'required|string|max:255' . Rule::unique('commodities')->ignore($commodity->id()),,
            'description' => 'nullable|string|max:500'
        ]);

        try {
            Commodity::update($request->all());
            return redirect()->route('commodities.index')->with('success', 'Barang berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui barang: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui barang!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commodity $commodity)
    {
        try {
            $commodity->delete();
            return redirect()->route('commodities.index')->with('success', 'Barang berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus barang: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('commodities.index')->with('error', 'Terjadi kesalahan saat menghapus barang!');
        }
    }
}
