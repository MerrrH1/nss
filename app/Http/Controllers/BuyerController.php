<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyers = Buyer::orderBy('name')->paginate(10);
        return view('buyers.index', compact('buyers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buyers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:buyers,name',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:buyers,email',
            'npwp' => 'nullable|string|max:20|unique:buyers,npwp',
        ]);

        try {
            Buyer::create($request->all());
            return redirect()->route('buyers.index')->with('success', 'Pembeli berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan pembeli: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan pembeli!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        return view('buyers.show', compact('buyer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buyer $buyer)
    {
        return view('buyers.edit', compact('buyer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buyer $buyer)
    {
        $request->validate([
            'name' => 'required|string|max:255' . Rule::unique('buyers')->ignore($buyer->id()),
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:buyers,email',
            'npwp' => 'nullable|string|max:20' . Rule::unique('buyers')->ignore($buyer->id()),
        ]);

        try {
            Buyer::update($request->all());
            return redirect()->route('buyers.index')->with('success', 'Pembeli berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui pembeli: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pembeli!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buyer $buyer)
    {
        try {
            $buyer->delete();
            return redirect()->route('buyers.index')->with('success', 'Pembeli berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus pembeli: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('buyers.index')->with('error', 'Terjadi kesalahan saat menghapus pembeli!');
        }
    }
}
