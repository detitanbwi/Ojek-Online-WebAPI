<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type',
        'name',
        'price_per_km',
        'free_flat_km',
        'base_price',
        'admin_commission_pct',
    ];

    protected $casts = [
        'price_per_km' => 'float',
        'free_flat_km' => 'float',
        'base_price' => 'float',
        'admin_commission_pct' => 'float',
    ];
}
