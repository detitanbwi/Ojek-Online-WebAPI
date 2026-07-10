<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Driver;
use App\Models\Order;
use App\Models\DriverWallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderMatchmakingTest extends TestCase
{
    use RefreshDatabase;

    public function test_automatic_matching_and_rejection_loop()
    {
        // 1. Create a customer
        $customer = User::create([
            'name' => 'Angga Test',
            'email' => 'angga.test@example.com',
            'password' => bcrypt('password123'),
            'balance' => 0.00,
        ]);

        // 2. Create Driver 1 (online, wiro_ride)
        $driver1 = Driver::create([
            'name' => 'Driver One',
            'phone' => '081234567801',
            'email' => 'driver1@example.com',
            'password' => bcrypt('password123'),
            'status_online' => true,
            'vehicle_type' => 'wiro_ride',
            'balance' => 0.00,
        ]);
        DriverWallet::create(['driver_id' => $driver1->id, 'balance' => 0.00]);

        // 3. Create Driver 2 (online, wiro_ride)
        $driver2 = Driver::create([
            'name' => 'Driver Two',
            'phone' => '081234567802',
            'email' => 'driver2@example.com',
            'password' => bcrypt('password123'),
            'status_online' => true,
            'vehicle_type' => 'wiro_ride',
            'balance' => 0.00,
        ]);
        DriverWallet::create(['driver_id' => $driver2->id, 'balance' => 0.00]);

        // 4. Create an order via Customer Create Order API
        $response = $this->postJson('/api/customer/create-order', [
            'customer_id' => $customer->id,
            'origin' => 'Kantor WiroDev',
            'destination' => 'Mall Bali Galeria',
            'price' => 20000,
            'payment_type' => 'cash',
            'service_type' => 'wiro_ride',
        ]);

        $response->assertStatus(201);
        $orderData = $response->json('data');
        $this->assertNotNull($orderData['driver_id']);
        
        $assignedDriverId = $orderData['driver_id'];
        $this->assertTrue(in_array($assignedDriverId, [$driver1->id, $driver2->id]));

        // Identify the other driver who was not matched first
        $otherDriverId = ($assignedDriverId === $driver1->id) ? $driver2->id : $driver1->id;

        // 5. Assigned driver rejects the order
        $rejectResponse = $this->postJson('/api/driver/order/status', [
            'order_id' => $orderData['id'],
            'status' => 'rejected',
        ]);

        $rejectResponse->assertStatus(200);
        
        // Assert the order gets matched to the other driver
        $updatedOrder = Order::find($orderData['id']);
        $this->assertEquals($otherDriverId, $updatedOrder->driver_id);
        $this->assertEquals('pending', $updatedOrder->status);
        $this->assertContains($assignedDriverId, $updatedOrder->rejected_driver_ids);

        // 6. The second driver also rejects the order
        $rejectResponse2 = $this->postJson('/api/driver/order/status', [
            'order_id' => $orderData['id'],
            'status' => 'rejected',
        ]);

        $rejectResponse2->assertStatus(200);

        // Assert the order status is now 'rejected' since no other online drivers match
        $finalOrder = Order::find($orderData['id']);
        $this->assertNull($finalOrder->driver_id);
        $this->assertEquals('rejected', $finalOrder->status);
        $this->assertContains($driver1->id, $finalOrder->rejected_driver_ids);
        $this->assertContains($driver2->id, $finalOrder->rejected_driver_ids);
    }
}
