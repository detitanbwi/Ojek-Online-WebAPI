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
        'email',
        'password',
        'onesignal_player_id',
        'status_online',
        'vehicle_type',
        'balance',
    ];

    protected $casts = [
        'status_online' => 'boolean',
        'balance' => 'float',
    ];

    /**
     * Get all of the orders for the Driver.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the wallet associated with the Driver.
     */
    public function wallet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(DriverWallet::class);
    }

    /**
     * Get all of the transactions for the Driver.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
