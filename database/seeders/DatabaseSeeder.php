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
                'balance' => 0.00,
            ]
        );

        // Seed Customer User (Angga)
        User::updateOrCreate(
            ['email' => 'angga@example.com'],
            [
                'name' => 'Angga',
                'password' => Hash::make('password123'),
                'balance' => 150000.00,
            ]
        );

        // Seed Customer User 2 (Dewi)
        User::updateOrCreate(
            ['email' => 'dewi@example.com'],
            [
                'name' => 'Dewi Puspita',
                'password' => Hash::make('password123'),
                'balance' => 75000.00,
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

        // Seed Driver User 2 (Bento)
        Driver::updateOrCreate(
            ['phone' => '081234567891'],
            [
                'name' => 'Bento',
                'email' => 'bento@wirojek.com',
                'password' => Hash::make('password123'),
                'status_online' => false,
                'vehicle_type' => 'wiro_car',
                'balance' => 50000.00,
            ]
        );
    }
}

