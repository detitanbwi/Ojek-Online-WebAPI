<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'customer_id',
        'origin',
        'destination',
        'price',
        'driver_fare',
        'admin_fee',
        'status',
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
