<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerApiController extends Controller
{
    /**
     * Create a new order (Customer side).
     */
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'price' => 'required|numeric|min:0',
            'payment_type' => 'required|in:cash,qris',
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
                // Fetch settings
                $commissionType = DB::table('admin_settings')->where('key', 'commission_type')->value('value') ?? 'percentage';
                $commissionValue = floatval(DB::table('admin_settings')->where('key', 'commission_value')->value('value') ?? 10);
                $roundDown = DB::table('admin_settings')->where('key', 'round_hundreds_down')->value('value') === 'true';

                $price = floatval($request->price);
                $adminFee = 0.0;

                if ($commissionType === 'percentage') {
                    $adminFee = $price * ($commissionValue / 100.0);
                    if ($roundDown) {
                        $adminFee = floor($adminFee / 100.0) * 100.0;
                    }
                } else {
                    $adminFee = $commissionValue;
                }

                $driverFare = max(0.0, $price - $adminFee);

                $user = \App\Models\User::find($request->customer_id);
                $passengerName = $user ? $user->name : 'Customer';

                // Create order
                $order = Order::create([
                    'customer_id' => $request->customer_id,
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'price' => $request->price,
                    'driver_fare' => $driverFare,
                    'admin_fee' => $adminFee,
                    'status' => 'pending',
                    'passenger_name' => $passengerName,
                    'payment_type' => $request->payment_type,
                ]);

                // Log the pending status
                OrderLog::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                ]);

                return $order;
            });

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully by customer',
                'data' => $order
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
     * Rate a completed order.
     */
    public function rateOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya orderan yang sudah selesai (completed) yang dapat diberikan rating.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'rating_driver' => 'required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update([
            'rating_driver' => $request->rating_driver
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil dikirimkan.',
            'data' => $order
        ], 200);
    }
}
