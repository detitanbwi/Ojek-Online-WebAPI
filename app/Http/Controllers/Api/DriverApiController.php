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

    /**
     * Get driver order history.
     */
    public function getOrders(Request $request)
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
        if (!$driver) {
            return response()->json(['success' => false, 'message' => 'Driver not found.'], 404);
        }

        $orders = Order::where('driver_id', $driver->id)->latest()->take(30)->get();
        return response()->json(['success' => true, 'data' => $orders], 200);
    }

    /**
     * Get current active order for driver (pending or accepted).
     */
    public function getActiveOrder(Request $request)
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
        if (!$driver) {
            return response()->json(['success' => false, 'message' => 'Driver not found.'], 404);
        }

        $order = Order::where('driver_id', $driver->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->latest()
            ->first();

        return response()->json(['success' => true, 'data' => $order], 200);
    }

    /**
     * Charge QRIS payment via Midtrans.
     */
    public function chargeQris(Request $request, \App\Services\MidtransService $midtransService)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::find($request->order_id);
        
        // Generate dynamic unique order ID suffix for Midtrans to avoid order ID collision
        $midtransOrderId = $order->id . '-' . time();
        $chargeResult = $midtransService->chargeQris($midtransOrderId, (int)$order->price);

        if ($chargeResult && isset($chargeResult['status_code']) && ($chargeResult['status_code'] == '201' || $chargeResult['status_code'] == '200')) {
            $qrCodeUrl = '';
            if (isset($chargeResult['actions'])) {
                foreach ($chargeResult['actions'] as $action) {
                    if ($action['name'] == 'generate-qr-code') {
                        $qrCodeUrl = $action['url'];
                        break;
                    }
                }
            }

            $order->update([
                'payment_type' => 'qris',
                'midtrans_order_id' => $midtransOrderId,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'midtrans_order_id' => $midtransOrderId,
                    'qr_code_url' => $qrCodeUrl,
                    'gross_amount' => $order->price,
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal memproses QRIS ke Midtrans.',
            'error' => $chargeResult
        ], 500);
    }

    /**
     * Check QRIS payment status from Midtrans.
     */
    public function checkPayment(Request $request, \App\Services\MidtransService $midtransService)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::find($request->order_id);
        if (!$order->midtrans_order_id) {
            return response()->json(['success' => false, 'message' => 'Order ini belum memicu pembayaran QRIS.'], 400);
        }

        $statusResult = $midtransService->checkStatus($order->midtrans_order_id);

        if ($statusResult && isset($statusResult['transaction_status'])) {
            $txStatus = $statusResult['transaction_status'];

            if ($txStatus == 'settlement' || $txStatus == 'capture') {
                if ($order->status !== 'completed') {
                    $order->update(['status' => 'completed']);
                    OrderLog::create([
                        'order_id' => $order->id,
                        'status' => 'completed',
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'status' => 'settlement',
                    'message' => 'Pembayaran QRIS lunas!',
                    'data' => $order
                ], 200);
            }

            return response()->json([
                'success' => true,
                'status' => $txStatus,
                'message' => 'Status transaksi: ' . $txStatus
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal memeriksa status ke Midtrans.',
            'error' => $statusResult
        ], 500);
    }

    /**
     * Bypass simulation to immediately complete payment.
     */
    public function simulatePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::find($request->order_id);
        if ($order->status !== 'completed') {
            $order->update(['status' => 'completed']);
            OrderLog::create([
                'order_id' => $order->id,
                'status' => 'completed',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Simulasi pembayaran sukses, orderan selesai!',
            'data' => $order
        ], 200);
    }
}
