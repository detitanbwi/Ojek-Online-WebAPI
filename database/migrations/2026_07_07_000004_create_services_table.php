<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_type')->unique(); // wiro_ride, wiro_car
            $table->string('name'); // WiroRide, WiroCar
            $table->decimal('price_per_km', 12, 2)->default(0);
            $table->decimal('free_flat_km', 8, 2)->default(0);
            $table->decimal('base_price', 12, 2)->default(0);
            $table->decimal('admin_commission_pct', 5, 2)->default(0); // e.g. 10.00%
            $table->timestamps();
        });

        // Seed default settings
        DB::table('services')->insert([
            [
                'service_type' => 'wiro_ride',
                'name' => 'WiroRide',
                'price_per_km' => 2000.00,
                'free_flat_km' => 2.00,
                'base_price' => 8000.00,
                'admin_commission_pct' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_type' => 'wiro_car',
                'name' => 'WiroCar',
                'price_per_km' => 4000.00,
                'free_flat_km' => 2.00,
                'base_price' => 25000.00,
                'admin_commission_pct' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
