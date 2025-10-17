<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nombre' => 'Fertilizante NPK',
                'tipo' => 'fertilizante',
                'categoria' => 'Fertilizante Completo',
                'cantidad' => 50,
                'unidad_medida' => 'kg',
                'precio_unitario' => 25.50,
                'stock_minimo' => 10,
                'proveedor' => 'AgroQuímica S.A.',
                'fecha_compra' => now()->subDays(30),
                'fecha_vencimiento' => now()->addDays(180),
                'ubicacion' => 'Almacén A',
                'descripcion' => 'Fertilizante balanceado para cultivos en general'
            ],
            [
                'nombre' => 'Semilla de Maíz Híbrido',
                'tipo' => 'semilla',
                'categoria' => 'Granos',
                'cantidad' => 5,
                'unidad_medida' => 'kg',
                'precio_unitario' => 45.00,
                'stock_minimo' => 2,
                'proveedor' => 'Semillas Premium',
                'fecha_compra' => now()->subDays(15),
                'fecha_vencimiento' => now()->addDays(365),
                'ubicacion' => 'Almacén B',
                'descripcion' => 'Semilla de alto rendimiento'
            ],
            // Agrega más items según necesites
        ];

        foreach ($items as $item) {
            Inventory::create(array_merge($item, [
                'user_id' => 1, // Ajusta según tu usuario
            ]));
        }
    }
}