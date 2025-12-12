<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Route::get('/', [UserController::class, 'showLogin'])->name('login');
Route::post('/identificacion', [UserController::class, 'verificalogin'])->name('identificacion');

Route::get('/salir', [UserController::class, 'salir'])->name('logout');
Route::get('/home',[HomeController::class,'index'])->name('home');