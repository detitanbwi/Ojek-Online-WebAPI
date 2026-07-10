<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@wirojek.com'],
            [
                'name' => 'Admin WiroJek',
                'password' => Hash::make('password123'),
            ]
        );

        // Seed Driver User (Wiro Sableng)
        Driver::updateOrCreate(
            ['phone' => '081234567890'],
            [
                'name' => 'Wiro Sableng',
                'email' => 'wiro@sableng.com',
                'password' => Hash::make('password123'),
                'status_online' => false,
                'vehicle_type' => 'wiro_ride',
                'balance' => 100000.00,
            ]
        );
    }
}

