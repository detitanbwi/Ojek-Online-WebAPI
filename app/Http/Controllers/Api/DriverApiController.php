<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverApiController extends Controller
{
    /**
     * Store OneSignal Player ID and set driver status to online.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'onesignal_player_id' => 'required|string',
            'name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find or create driver by phone number
        $driver = Driver::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => $request->name ?? 'Driver ' . substr($request->phone, -4)]
        );

        // Update OneSignal player ID and set status online
        $driver->update([
            'onesignal_player_id' => $request->onesignal_player_id,
            'status_online' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Driver logged in successfully and status set to online.',
            'data' => $driver
        ], 200);
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:accepted,rejected,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::find($request->order_id);
        $order->update(['status' => $request->status]);

        // Log the change
        OrderLog::create([
            'order_id' => $order->id,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated to ' . $request->status,
            'data' => $order
        ], 200);
    }

    /**
     * Set driver status to offline.
     */
    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $driver = Driver::where('phone', $request->phone)->first();
        if ($driver) {
            $driver->update([
                'status_online' => false,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Driver status set to offline.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Driver not found.',
        ], 404);
    }
}
