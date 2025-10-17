<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Inventory;
use App\Models\Ganado;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Verificar que las tablas existen y obtener conteos
            $totalCrops = Schema::hasTable('crops') ? Crop::count() : 0;
            $totalInventory = Schema::hasTable('inventories') ? Inventory::count() : 0;
            $totalGanado = Schema::hasTable('ganados') ? Ganado::count() : 0;
            
            // Cultivos por estado (con verificación segura)
            $cultivosSaludables = 0;
            $cultivosEnfermos = 0;
            $cultivosRiesgo = 0;
            
            if (Schema::hasTable('crops')) {
                if (Schema::hasColumn('crops', 'estado')) {
                    $cultivosSaludables = Crop::where('estado', 'saludable')->count();
                    $cultivosEnfermos = Crop::where('estado', 'enfermo')->count();
                    $cultivosRiesgo = Crop::where('estado', 'riesgo')->count();
                } else {
                    // Si no existe columna estado, todos están "saludables"
                    $cultivosSaludables = $totalCrops;
                }
            }
            
            // Ganado por estado (con verificación segura)
            $ganadoSaludable = 0;
            $ganadoEnfermo = 0;
            
            if (Schema::hasTable('ganados')) {
                if (Schema::hasColumn('ganados', 'estado')) {
                    $ganadoSaludable = Ganado::where('estado', 'saludable')->count();
                    $ganadoEnfermo = Ganado::where('estado', 'enfermo')->count();
                } else {
                    // Si no existe columna estado, todos están "saludables"
                    $ganadoSaludable = $totalGanado;
                }
            }
            
            // Inventario con bajo stock
            $inventarioBajoStock = 0;
            if (Schema::hasTable('inventories') && Schema::hasColumn('inventories', 'cantidad')) {
                $inventarioBajoStock = Inventory::where('cantidad', '<=', 10)->count();
            }

            return view('dashboard.index', compact(
                'totalCrops',
                'totalInventory', 
                'totalGanado',
                'cultivosSaludables',
                'cultivosEnfermos', 
                'cultivosRiesgo',
                'ganadoSaludable',
                'ganadoEnfermo',
                'inventarioBajoStock'
            ));
            
        } catch (\Exception $e) {
            // En caso de cualquier error, mostrar dashboard con ceros
            return view('dashboard.index', [
                'totalCrops' => 0,
                'totalInventory' => 0,
                'totalGanado' => 0,
                'cultivosSaludables' => 0,
                'cultivosEnfermos' => 0,
                'cultivosRiesgo' => 0,
                'ganadoSaludable' => 0,
                'ganadoEnfermo' => 0,
                'inventarioBajoStock' => 0
            ]);
        }
    }
}