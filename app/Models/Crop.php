<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $fillable = [
        'name',
        'field_location',
        'planted_at',
        'crop_type',
        'moisture_threshold', // humedad mínima (por ejemplo 30 => 30%)
        'temp_min',
        'temp_max',
        'status' // healthy, needs_irrigation, attention
    ];

    protected $casts = [
        'planted_at' => 'datetime',
    ];
}
