<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'service_type' => 'nullable|string|in:wiro_ride,wiro_car',
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
                $serviceType = $request->service_type ?? 'wiro_ride';
                
                // Fetch dynamic service setting from db
                $service = DB::table('services')->where('service_type', $serviceType)->first();
                $commissionPct = $service ? floatval($service->admin_commission_pct) : 10.0;
                
                $roundDown = DB::table('admin_settings')->where('key', 'round_hundreds_down')->value('value') === 'true';

                $price = floatval($request->price);
                $adminFee = $price * ($commissionPct / 100.0);
                if ($roundDown) {
                    $adminFee = floor($adminFee / 100.0) * 100.0;
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
                    'service_type' => $serviceType,
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
     * Get estimated fares for WiroRide and WiroCar based on distance.
     */
    public function estimateFares(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'distance' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $distance = floatval($request->distance);
            $services = DB::table('services')->get();

            $estimates = [];
            foreach ($services as $service) {
                // Calculation: base_price + max(0, distance - free_flat_km) * price_per_km
                $price = floatval($service->base_price);
                $freeFlat = floatval($service->free_flat_km);
                
                if ($distance > $freeFlat) {
                    $price += ($distance - $freeFlat) * floatval($service->price_per_km);
                }

                // Round to nearest 1000 for premium user experience
                $price = ceil($price / 1000.0) * 1000.0;

                $description = $service->service_type === 'wiro_ride'
                    ? 'Ojek Motor Cepat (3-5 mnt)'
                    : 'Mobil Nyaman AC (5-8 mnt)';

                $image = $service->service_type === 'wiro_ride'
                    ? 'assets/images/wiro_ride.png'
                    : 'assets/images/wiro_car.png';

                $estimates[] = [
                    'id' => $service->service_type,
                    'name' => $service->name,
                    'description' => $description,
                    'image' => $image,
                    'price' => intval($price),
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $estimates
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate fares',
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

    /**
     * Register a new Customer.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi customer berhasil.',
            'data' => $user
        ], 201);
    }

    /**
     * Authenticate Customer.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login customer berhasil.',
            'data' => $user
        ], 200);
    }

    /**
     * Cancel an active order from customer side.
     */
    public function cancelOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.'
            ], 404);
        }

        if (in_array($order->status, ['pending', 'accepted'])) {
            $order->update(['status' => 'cancelled']);
            
            OrderLog::create([
                'order_id' => $order->id,
                'status' => 'cancelled',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibatalkan.'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Order tidak dapat dibatalkan karena status: ' . $order->status
        ], 400);
    }

    /**
     * Check details and status of an order.
     */
    public function getOrderStatus($id)
    {
        $order = Order::with('driver')->find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ], 200);
    }

    /**
     * Get customer profile.
     */
    public function getProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email parameter wajib diisi.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }
}
