<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\UsuarioController;

Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.index');

Route::resource('usuario', UsuarioController::class);
Route::resource('mascota', MascotaController::class);
Route::resource('historiaclinica', HistoriaClinicaController::class);