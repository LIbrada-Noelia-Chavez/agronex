<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'categoria',
        'cantidad',
        'unidad_medida',
        'precio_unitario',
        'stock_minimo',
        'stock_maximo',
        'proveedor',
        'fecha_compra',
        'fecha_vencimiento',
        'ubicacion',
        'descripcion',
        'estado',
        'user_id'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'stock_maximo' => 'decimal:2',
        'fecha_compra' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    // Scope para items con bajo stock
    public function scopeBajoStock($query)
    {
        return $query->whereColumn('cantidad', '<=', 'stock_minimo');
    }

    // Scope para items próximos a vencer
    public function scopeProximoVencer($query)
    {
        return $query->whereNotNull('fecha_vencimiento')
                    ->where('fecha_vencimiento', '<=', now()->addDays(30));
    }

    // Calcular valor total del item
    public function getValorTotalAttribute()
    {
        return $this->cantidad * ($this->precio_unitario ?? 0);
    }

    // Verificar si está bajo stock
    public function getEstaBajoStockAttribute()
    {
        return $this->cantidad <= $this->stock_minimo;
    }

    // Verificar si está próximo a vencer
    public function getEstaProximoVencerAttribute()
    {
        if (!$this->fecha_vencimiento) return false;
        return $this->fecha_vencimiento <= now()->addDays(30);
    }
}