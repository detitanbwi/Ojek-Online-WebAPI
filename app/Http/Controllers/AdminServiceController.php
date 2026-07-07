<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string|max:255|unique:services,service_type',
            'name' => 'required|string|max:255',
            'price_per_km' => 'required|numeric|min:0',
            'free_flat_km' => 'required|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
            'admin_commission_pct' => 'required|numeric|min:0|max:100',
        ]);

        Service::create([
            'service_type' => $request->service_type,
            'name' => $request->name,
            'price_per_km' => $request->price_per_km,
            'free_flat_km' => $request->free_flat_km,
            'base_price' => $request->base_price,
            'admin_commission_pct' => $request->admin_commission_pct,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_km' => 'required|numeric|min:0',
            'free_flat_km' => 'required|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
            'admin_commission_pct' => 'required|numeric|min:0|max:100',
        ]);

        $service->update([
            'name' => $request->name,
            'price_per_km' => $request->price_per_km,
            'free_flat_km' => $request->free_flat_km,
            'base_price' => $request->base_price,
            'admin_commission_pct' => $request->admin_commission_pct,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan ' . $service->name . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if (Service::count() <= 1) {
            return redirect()->route('admin.services.index')->with('error', 'Minimal harus disisakan 1 layanan. Layanan tidak boleh kosong.');
        }

        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
