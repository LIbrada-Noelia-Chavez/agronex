<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
protected $fillable = [
  'name','field_location','planted_at','crop_type','moisture_threshold','temp_min','temp_max','status',
  'presentation','price','coverage_value','coverage_unit'
];

protected $casts = [
  'planted_at' => 'datetime',
  'price' => 'decimal:2',
  'coverage_value' => 'decimal:2',
];

}
