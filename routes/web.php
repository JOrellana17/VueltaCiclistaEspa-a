<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CiclistaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\GanadorController;
use App\Http\Controllers\ParticipaController;
use App\Http\Controllers\PruebaController;

Route::get('/', function () {
    return view('index');
});

Route::resource('ciclista', CiclistaController::class);
Route::resource('equipo', EquipoController::class);
Route::resource('participa', ParticipaController::class);
Route::resource('prueba', PruebaController::class);

Route::patch('participa/{id}/estado', [ParticipaController::class, 'toggleEstado'])->name('participa.estado');

Route::get('ganador', [GanadorController::class, 'index'])->name('ganador.index');
Route::get('ganador/create', [GanadorController::class, 'create'])->name('ganador.create');
Route::post('ganador', [GanadorController::class, 'store'])->name('ganador.store');
