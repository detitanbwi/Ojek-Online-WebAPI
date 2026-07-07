<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('vehicle_type')->default('wiro_ride')->after('status_online'); // wiro_ride, wiro_car
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('service_type')->default('wiro_ride')->after('status'); // wiro_ride, wiro_car
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('vehicle_type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });
    }
};
