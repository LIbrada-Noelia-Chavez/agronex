<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GanadoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\CropController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home + Dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

// Módulos simples
Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario');
Route::get('/sensores', [SensorController::class, 'index'])->name('sensores');

// ---- Cultivos (solo presets + CRUD) ----
// Crear desde una tarjeta/preset (POST desde la vista select)
Route::post('cultivos/preset', [CropController::class, 'storeFromPreset'])->name('cultivos.storePreset');

Route::resource('cultivos', CropController::class)->names('cultivos');
Route::post('cultivos/preset', [CropController::class, 'storeFromPreset'])->name('cultivos.storePreset');
Route::resource('ganado', GanadoController::class)->names('ganado');
