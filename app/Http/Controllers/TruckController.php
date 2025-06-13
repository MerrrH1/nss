<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trucks = Truck::orderBy('name')->paginate(10);
        return view('trucks.index', compact('trucks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trucks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'driver_name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:trucks,plate_number',
            'capacity_kg' => 'required|integer|min:1'
        ]);

        try {
            Truck::create($request->all());
            return redirect()->route('trucks.index')->with('success', 'Truk berhasil ditambahkan!');
        } catch (Exception $e) {
            Log::error("Gagal menambahkan truk: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan truk!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Truck $truck)
    {
        return view('trucks.show', compact('truck'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Truck $truck)
    {
        return view('trucks.edit', compact('truck'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Truck $truck)
    {
        $request->validate([
            'driver_name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:trucks,plate_number',
            'capacity_kg' => 'required|integer|min:1'
        ]);

        try {
            Truck::update($request->all());
            return redirect()->route('trucks.index')->with('success', 'Truk berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal memperbarui truk: {$e->getMessage()}", ['exception' => $e]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui truk!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Truck $truck)
    {
        try {
            $truck->delete();
            return view('trucks.index')->with('success', 'Truk berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Gagal menghapus truk: {$e->getMessage()}", ['exception' => $e]);
            return redirect()->route('trucks.index')->with('error', 'Terjadi kesalahan saat menghapus truk!');
        }
    }
}
