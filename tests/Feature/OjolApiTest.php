<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OjolApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test driver login endpoint.
     */
    public function test_driver_can_login(): void
    {
        $response = $this->postJson('/api/driver/login', [
            'name' => 'Wiro Sableng',
            'phone' => '081234567890',
            'onesignal_player_id' => 'onesignal-test-uuid-12345',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Driver logged in successfully and status set to online.',
            ]);

        $this->assertDatabaseHas('drivers', [
            'name' => 'Wiro Sableng',
            'phone' => '081234567890',
            'onesignal_player_id' => 'onesignal-test-uuid-12345',
            'status_online' => true,
        ]);
    }

    /**
     * Test admin create order endpoint.
     */
    public function test_admin_can_create_order(): void
    {
        // First create a driver
        $driver = Driver::create([
            'name' => 'Wiro Sableng',
            'phone' => '081234567890',
            'onesignal_player_id' => 'onesignal-test-uuid-12345',
            'status_online' => true,
        ]);

        $response = $this->postJson('/api/admin/create-order', [
            'origin' => 'Pasar Banyuwangi',
            'destination' => 'Stasiun Karangasem',
            'price' => 25000,
            'driver_id' => $driver->id,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Order created successfully',
            ]);

        $this->assertDatabaseHas('orders', [
            'driver_id' => $driver->id,
            'origin' => 'Pasar Banyuwangi',
            'destination' => 'Stasiun Karangasem',
            'price' => 25000,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('order_logs', [
            'status' => 'pending',
        ]);
    }
}
