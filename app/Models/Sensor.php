<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'ubicacion',
        'valor',
        'unidad',
        'estado',
        'ultima_lectura',
        'descripcion'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'ultima_lectura' => 'datetime',
    ];
}