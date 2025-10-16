<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GanadoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\CropController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/ganado', [GanadoController::class, 'index'])->name('ganado');
Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario');
Route::get('/sensores', [SensorController::class, 'index'])->name('sensores');

// RUTAS NUEVAS: Cultivos
Route::get('/cultivos', [CropController::class, 'index'])->name('cultivos.index');
Route::get('/cultivos/{crop}', [CropController::class, 'show'])->name('cultivos.show');
Route::get('/cultivos/create', [CropController::class, 'create'])->name('cultivos.create');
Route::post('/cultivos', [CropController::class, 'store'])->name('cultivos.store');
