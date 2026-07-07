<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public static $adminCommissionRate = 0.10; // Keterangan: Potongan komisi platform sebesar 10% dari total tarif per orderan sukses

    protected static function booted()
    {
        static::updated(function ($order) {
            // Trigger when status transitions to completed
            if ($order->isDirty('status') && $order->status === 'completed') {
                $driver = $order->driver;
                if ($driver) {
                    // Fetch dynamic commission rate from services table based on service_type
                    $service = DB::table('services')->where('service_type', $order->service_type)->first();
                    $commissionRate = $service ? (floatval($service->admin_commission_pct) / 100.0) : 0.10;

                    // Calculate commission and driver share
                    $price = floatval($order->price);
                    $adminFee = $price * $commissionRate;
                    $driverFare = max(0.0, $price - $adminFee);

                    // Update order fields quietly to prevent infinite loops
                    $order->updateQuietly([
                        'admin_fee' => $adminFee,
                        'driver_fare' => $driverFare,
                    ]);

                    // Update or create driver wallet in driver_wallets
                    $wallet = \App\Models\DriverWallet::firstOrCreate(
                        ['driver_id' => $driver->id],
                        ['balance' => 0]
                    );
                    $wallet->increment('balance', $driverFare);

                    // Sync to drivers table balance column
                    $driver->increment('balance', $driverFare);

                    // Create transaction record
                    $pctText = ($commissionRate * 100) . '%';
                    \App\Models\Transaction::create([
                        'reference_id' => 'TX-COM-' . $order->id . '-' . time() . '-' . rand(1000, 9999),
                        'order_id' => $order->id,
                        'driver_id' => $driver->id,
                        'type' => 'commission_in',
                        'amount' => $adminFee,
                        'description' => "Komisi admin {$pctText} dari order #{$order->id} (Tarif: Rp " . number_format($price, 0, ',', '.') . ")",
                    ]);
                }
            }
        });
    }

    protected $fillable = [
        'driver_id',
        'customer_id',
        'origin',
        'destination',
        'price',
        'driver_fare',
        'admin_fee',
        'status',
        'service_type',
        'payment_type',
        'midtrans_order_id',
        'passenger_name',
        'rating_driver',
    ];

    protected $casts = [
        'price' => 'float',
        'driver_fare' => 'float',
        'admin_fee' => 'float',
        'rating_driver' => 'integer',
    ];

    /**
     * Get the driver that owns the Order.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the customer that owns the Order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get all of the logs for the Order.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(OrderLog::class);
    }
}
