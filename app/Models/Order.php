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
        'origin',
        'destination',
        'price',
        'driver_fare',
        'admin_fee',
        'status',
        'payment_type',
        'midtrans_order_id',
        'passenger_name',
    ];

    protected $casts = [
        'price' => 'float',
        'driver_fare' => 'float',
        'admin_fee' => 'float',
    ];

    /**
     * Get the driver that owns the Order.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get all of the logs for the Order.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(OrderLog::class);
    }
}
