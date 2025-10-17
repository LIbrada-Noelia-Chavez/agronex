<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ganado extends Model
{
    use HasFactory;

    protected $table = 'ganados';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'identificador',
        'raza', 
        'edad',
        'peso',
        'sexo',
        'estado',
        'fecha_ingreso',
        'lote',
        'observaciones'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'edad' => 'integer',
        'peso' => 'float',
        'fecha_ingreso' => 'date',
    ];
}