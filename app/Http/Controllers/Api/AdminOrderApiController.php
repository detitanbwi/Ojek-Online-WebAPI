<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Driver;
use App\Services\OneSignalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminOrderApiController extends Controller
{
    protected OneSignalService $oneSignalService;

    public function __construct(OneSignalService $oneSignalService)
    {
        $this->oneSignalService = $oneSignalService;
    }

    /**
     * Create a new order and notify the driver.
     */
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin' => 'required|string',
            'destination' => 'required|string',
            'price' => 'required|numeric|min:0',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = DB::transaction(function () use ($request) {
                // Generate a random typical Indonesian passenger name for simulation
                $passengerNames = ['Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Dewi Lestari', 'Joko Susilo', 'Rini Wulandari', 'Rian Hidayat', 'Mega Utami'];
                $randomName = $passengerNames[array_rand($passengerNames)];

                // 1. Create order
                $order = Order::create([
                    'driver_id' => $request->driver_id,
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'price' => $request->price,
                    'status' => 'pending',
                    'passenger_name' => $request->passenger_name ?? $randomName,
                    'payment_type' => $request->payment_type ?? 'cash',
                ]);

                // 2. Create order log
                OrderLog::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                ]);

                return $order;
            });

            // 3. Send OneSignal Notification
            $driver = Driver::find($request->driver_id);
            $notificationSent = false;
            $notificationError = null;

            if ($driver && $driver->onesignal_player_id) {
                $payloadData = [
                    'type' => 'NEW_ORDER',
                    'order_id' => (string)$order->id,
                    'origin' => $order->origin,
                    'destination' => $order->destination,
                    'price' => (string)$order->price,
                    'passenger_name' => $order->passenger_name,
                    'payment_type' => $order->payment_type,
                ];

                $title = 'Order Baru!';
                $message = "Antar dari {$order->origin} ke {$order->destination}. Tarif: Rp " . number_format($order->price, 0, ',', '.');

                $notificationResult = $this->oneSignalService->sendNotification(
                    $driver->onesignal_player_id,
                    $title,
                    $message,
                    $payloadData
                );

                $notificationSent = $notificationResult['success'];
                if (!$notificationSent) {
                    $notificationError = $notificationResult['message'] ?? 'Unknown error';
                }
            } else {
                $notificationError = 'Driver does not have a OneSignal player ID registered';
            }

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => $order,
                    'notification_sent' => $notificationSent,
                    'notification_error' => $notificationError,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all registered drivers.
     */
    public function getDrivers()
    {
        $drivers = Driver::all();
        return response()->json([
            'success' => true,
            'data' => $drivers
        ], 200);
    }

    /**
     * Force disconnect (detach) a driver from dashboard.
     */
    public function detachDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $driver = Driver::find($request->driver_id);
        if ($driver) {
            $driver->update([
                'status_online' => false,
                'onesignal_player_id' => null, // force clearing so notifications won't go to detached devices
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Driver detached successfully.'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Driver not found.'
        ], 404);
    }
}
