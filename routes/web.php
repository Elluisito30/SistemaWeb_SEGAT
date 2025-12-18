<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GerenteController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\CiudadanoController;

// -----------------------------------
// RUTAS DE LOGIN
// -----------------------------------
Route::get('/', [UserController::class, 'showLogin'])->name('login');
Route::post('/identificacion', [UserController::class, 'verificalogin'])->name('identificacion');

// --------------------
// RUTA PARA CERRAR SESIÓN
// --------------------
Route::get('/salir', [UserController::class, 'salir'])->name('logout.get')->middleware('auth');
Route::post('/salir', [UserController::class, 'salir'])->name('logout')->middleware('auth');

// ------------------------
// RUTAS PARA GERENTE
// ------------------------
Route::middleware(['auth', 'role:gerente'])->prefix('gerente')->name('gerente.')->group(function () {
    Route::get('/dashboard', [GerenteController::class, 'dashboard'])->name('dashboard');
    // Aquí irán más rutas del gerente según tu proyecto
});

// ------------------------
// RUTAS PARA TRABAJADOR
// ------------------------
Route::middleware(['auth', 'role:trabajador'])->prefix('trabajador')->name('trabajador.')->group(function () {
    Route::get('/dashboard', [TrabajadorController::class, 'dashboard'])->name('dashboard');
    // Aquí irán más rutas del trabajador según tu proyecto
});

// ------------------------
// RUTAS PARA CIUDADANO
// ------------------------
Route::middleware(['auth', 'role:ciudadano'])->prefix('ciudadano')->name('ciudadano.')->group(function () {
    Route::get('/dashboard', [CiudadanoController::class, 'dashboard'])->name('dashboard');
    // Aquí irán más rutas del ciudadano según tu proyecto
});

// -----------------------------
// RUTA HOME SEGÚN TIPO DE ROL
// -----------------------------
Route::get('/home', function () {   // Al entrar en la ruta Home redirige al home indicado
    $user = auth()->user();

    if ($user->role === 'gerente') {
        return redirect()->route('gerente.dashboard');
    } elseif ($user->role === 'trabajador') {
        return redirect()->route('trabajador.dashboard');
    } elseif ($user->role === 'ciudadano') {
        return redirect()->route('ciudadano.dashboard');
    }

    return redirect()->route('login');
})->name('home')->middleware('auth');