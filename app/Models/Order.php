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
        'status',
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
