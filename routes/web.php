<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Rutas Web - AgroNex
|--------------------------------------------------------------------------
|
| Este archivo contiene las rutas principales de la aplicación.
| Incluye autenticación, dashboard y control de roles.
|
*/

// =======================================================
// 🔒 Redirigir la raíz al login
// =======================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// =======================================================
// 🔐 AUTENTICACIÓN MANUAL (Login / Logout)
// =======================================================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =======================================================
// 🧩 REGISTRO (por si se usa formulario de register.blade.php)
// =======================================================
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

// =======================================================
// 🚧 RUTAS PROTEGIDAS (solo usuarios autenticados)
// =======================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 🏠 Dashboard (todos los usuarios autenticados)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 👤 Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===================================================
    // 🌱 Capataz de Cultivo
    // ===================================================
    Route::middleware(['role:capataz_cultivo,admin'])->group(function () {
        Route::get('/cultivos', function () {
            return view('cultivos.index');
        })->name('cultivos.index');
    });

    // ===================================================
    // 🐄 Capataz de Ganado
    // ===================================================
    Route::middleware(['role:capataz_ganado,admin'])->group(function () {
        Route::get('/ganado', function () {
            return view('ganado.index');
        })->name('ganado.index');
    });

    // ===================================================
    // ⚙️ Panel del Administrador
    // ===================================================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});

// =======================================================
// 📦 Importar las rutas por defecto de autenticación (Breeze / Fortify)
// =======================================================
require __DIR__ . '/auth.php';
