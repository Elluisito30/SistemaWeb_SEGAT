<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistroController; 
use App\Http\Controllers\GerenteController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\CiudadanoController;
use App\Http\Controllers\SolicitudLimpiezaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\InfraccionController;

// -----------------------------------
// RUTAS DE LOGIN
// -----------------------------------
Route::get('/', [UserController::class, 'showLogin'])->name('login');
Route::post('/identificacion', [UserController::class, 'verificalogin'])->name('identificacion');

// --------------------
// RUTA PARA REGISTRARSE
// --------------------
Route::get('/registrarse', [RegistroController::class, 'showRegistrationForm'])->name('registro');
Route::post('/registrarse', [RegistroController::class, 'verificarRegistro'])->name('registrarse');

// --------------------
// RUTA PARA CERRAR SESIÓN
// --------------------
Route::get('/salir', [UserController::class, 'salir'])->name('logout.get')->middleware('auth');
Route::post('/salir', [UserController::class, 'salir'])->name('logout')->middleware('auth');

// ------------------------
// RUTAS PARA GERENTE
// ------------------------
Route::middleware(['auth', 'role:ciudadano'])->prefix('ciudadano')->name('ciudadano.')->group(function () {
    Route::get('/dashboard', [CiudadanoController::class, 'dashboard'])->name('dashboard');
    
    // Rutas de solicitudes de limpieza
    Route::resource('/solicitud', SolicitudLimpiezaController::class)->except(['show']);  
    Route::get('solicitud/cancelar', function () {   
        return redirect()->route('ciudadano.solicitud.index')->with('datos','Acción Cancelada..!');   
    })->name('solicitud.cancelar');  
    Route::get('solicitud/{id}/confirmar',[SolicitudLimpiezaController::class,'confirmar'])->name('solicitud.confirmar');
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
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    
    // Registrar infracción
    Route::get('/infracciones/crear', [InfraccionController::class, 'create'])->name('infracciones.create');
    Route::post('/infracciones', [InfraccionController::class, 'store'])->name('infracciones.store');

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


// Ruta para Trabajador
Route::Resource('/trabajador', TrabajadorController::class);
Route::get('/trabajador/{id}/confirmar', [TrabajadorController::class, 'confirmar'])->name('trabajador.confirmar');
Route::get('/cancelar',function(){
    return redirect()->route('trabajador.index')->with('datos','Acción cancelada  !!!');
})->name('trabajador.cancelar');