<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfraccionController;

Route::get('/', [UserController::class, 'showLogin'])->name('login');
Route::post('/identificacion', [UserController::class, 'verificalogin'])->name('identificacion');

Route::get('/salir', [UserController::class, 'salir'])->name('logout');
Route::get('/home',[HomeController::class,'index'])->name('home');

//Rutas para infracción
Route::Resource('/infraccion', InfraccionController::class);
Route::get('/infraccion/{id}/confirmar', [InfraccionController::class, 'confirmar'])->name('infraccion.confirmar');
Route::get('/cancelar',function(){
    return redirect()->route('infraccion.index')->with('datos','Acción cancelada  !!!');
})->name('infraccion.cancelar');
