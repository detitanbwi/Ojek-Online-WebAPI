<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update drivers table
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('name');
            $table->string('password')->nullable()->after('email');
        });

        // 2. Update orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('driver_fare', 12, 2)->default(0)->after('price');
            $table->decimal('admin_fee', 12, 2)->default(0)->after('driver_fare');
        });

        // 3. Create admin_settings table
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 4. Seed default settings
        DB::table('admin_settings')->insert([
            ['key' => 'commission_type', 'value' => 'percentage', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'commission_value', 'value' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'round_hundreds_down', 'value' => 'true', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['driver_fare', 'admin_fee']);
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn(['email', 'password']);
        });
    }
};
