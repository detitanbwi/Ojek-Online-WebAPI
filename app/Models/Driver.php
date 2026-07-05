<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'onesignal_player_id',
        'status_online',
    ];

    protected $casts = [
        'status_online' => 'boolean',
    ];

    /**
     * Get all of the orders for the Driver.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
