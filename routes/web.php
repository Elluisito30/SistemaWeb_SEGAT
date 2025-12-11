<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;


Route::get('/',[UserController::class,'showLogin']);
Route::post('/identificacion', [UserController::class,'verificalogin'])->name('identificacion');
Route::get('/login', [UserController::class, 'showLogin'])->name('login');  
//El primer login es para la ruta del navegador (ejm: Mipagina.com/login) y el segundo login es para referenciarlo en el mismo laravel (Ejm: route('login'))

Route::get('/home',[HomeController::class,'index'])->name('home'); 
