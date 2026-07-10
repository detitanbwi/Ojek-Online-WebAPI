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

    public function test_customer_unrated_order_endpoint_and_rating_averaging()
    {
        // 1. Create a customer
        $customer = User::create([
            'name' => 'Dewi Test',
            'email' => 'dewi.test@example.com',
            'password' => bcrypt('password123'),
            'balance' => 0.00,
        ]);

        // 2. Create a driver
        $driver = Driver::create([
            'name' => 'Wiro Test Rating',
            'phone' => '081234567899',
            'email' => 'wiro.rating@example.com',
            'password' => bcrypt('password123'),
            'status_online' => true,
            'vehicle_type' => 'wiro_ride',
            'balance' => 0.00,
        ]);
        DriverWallet::create(['driver_id' => $driver->id, 'balance' => 0.00]);

        // 3. Create Order 1 (completed, unrated)
        $order1 = Order::create([
            'customer_id' => $customer->id,
            'driver_id' => $driver->id,
            'origin' => 'Start 1',
            'destination' => 'End 1',
            'price' => 10000,
            'driver_fare' => 9000,
            'admin_fee' => 1000,
            'status' => 'completed',
            'service_type' => 'wiro_ride',
            'payment_type' => 'cash',
        ]);

        // 4. Create Order 2 (completed, unrated)
        $order2 = Order::create([
            'customer_id' => $customer->id,
            'driver_id' => $driver->id,
            'origin' => 'Start 2',
            'destination' => 'End 2',
            'price' => 12000,
            'driver_fare' => 10800,
            'admin_fee' => 1200,
            'status' => 'completed',
            'service_type' => 'wiro_ride',
            'payment_type' => 'cash',
        ]);

        // Call unrated orders API. Should return the most recent one (Order 2)
        $response = $this->getJson('/api/customer/orders/unrated?email=' . $customer->email);
        $response->assertStatus(200);
        $this->assertEquals($order2->id, $response->json('data.id'));

        // Verify driver profile rating calculation (should NOT count unrated null as 0, but fallback to 5.0 since no rating exists yet)
        $driverProfileResponse = $this->getJson('/api/driver/profile?email=' . $driver->email);
        $driverProfileResponse->assertStatus(200);
        $this->assertEquals(5.0, $driverProfileResponse->json('data.rating'));

        // Rate Order 2 as 4 stars
        $rateResponse = $this->postJson("/api/orders/{$order2->id}/rate", [
            'rating_driver' => 4,
        ]);
        $rateResponse->assertStatus(200);

        // Fetch unrated orders API again. Should now return Order 1 (since Order 2 is rated)
        $response2 = $this->getJson('/api/customer/orders/unrated?email=' . $customer->email);
        $response2->assertStatus(200);
        $this->assertEquals($order1->id, $response2->json('data.id'));

        // Rate Order 1 as 5 stars
        $rateResponse2 = $this->postJson("/api/orders/{$order1->id}/rate", [
            'rating_driver' => 5,
        ]);
        $rateResponse2->assertStatus(200);

        // Fetch unrated orders API again. Should return null since all are rated
        $response3 = $this->getJson('/api/customer/orders/unrated?email=' . $customer->email);
        $response3->assertStatus(200);
        $this->assertNull($response3->json('data'));

        // Verify driver profile rating calculation (should be average of 4 and 5 which is 4.5)
        $driverProfileResponse2 = $this->getJson('/api/driver/profile?email=' . $driver->email);
        $driverProfileResponse2->assertStatus(200);
        $this->assertEquals(4.5, $driverProfileResponse2->json('data.rating'));
    }
}
