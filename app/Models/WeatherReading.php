<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherReading extends Model
{
    protected $fillable = ['crop_id', 'source', 'type', 'value', 'payload', 'read_at'];
    protected $casts = ['payload' => 'array', 'read_at' => 'datetime'];
}
