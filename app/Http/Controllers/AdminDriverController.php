<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminDriverController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:drivers',
            'phone' => 'required|string|max:20|unique:drivers',
            'password' => 'required|string|min:6',
        ]);

        Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status_online' => false,
            'balance' => 0.00,
        ]);

        return redirect()->route('dashboard')->with('success', 'Driver berhasil didaftarkan.');
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:drivers,email,' . $driver->id,
            'phone' => 'required|string|max:20|unique:drivers,phone,' . $driver->id,
            'balance' => 'required|numeric|min:0',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'balance' => $request->balance,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $driver->update($updateData);

        return redirect()->route('dashboard')->with('success', 'Data driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('dashboard')->with('success', 'Driver berhasil dihapus.');
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'commission_type' => 'required|in:percentage,fixed',
            'commission_value' => 'required|numeric|min:0',
            'round_hundreds_down' => 'nullable',
        ]);

        DB::table('admin_settings')->updateOrInsert(
            ['key' => 'commission_type'],
            ['value' => $request->commission_type, 'updated_at' => now()]
        );

        DB::table('admin_settings')->updateOrInsert(
            ['key' => 'commission_value'],
            ['value' => $request->commission_value, 'updated_at' => now()]
        );

        $roundDown = $request->commission_type === 'percentage' && $request->has('round_hundreds_down') ? 'true' : 'false';
        DB::table('admin_settings')->updateOrInsert(
            ['key' => 'round_hundreds_down'],
            ['value' => $roundDown, 'updated_at' => now()]
        );

        return redirect()->route('dashboard')->with('success', 'Pengaturan komisi berhasil disimpan.');
    }

    public function showOrder(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => $order->load('driver')
        ]);
    }
}
