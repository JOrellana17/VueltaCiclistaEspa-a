<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CiclistaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\GanadorController;
use App\Http\Controllers\ParticipaController;
use App\Http\Controllers\PruebaController;

/* Rutas de autenticacion, accesibles sin sesion activa */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* Rutas protegidas que requieren sesion activa */
Route::middleware('sesion')->group(function () {

    /* Pagina de acceso denegado para roles sin permiso */
    Route::get('/acceso-denegado', fn () => view('auth.acceso-denegado'))->name('acceso.denegado');

    /* Panel principal, visible para todos los roles */
    Route::get('/', fn () => view('index'));

    /* Modulo de equipos: lectura para todos, escritura solo para admin y encargado */
    Route::prefix('equipo')->name('equipo.')->group(function () {
        Route::get('/', [EquipoController::class, 'index'])->name('index');

        /* Rutas de escritura exclusivas para admin (0) y encargado (1) */
        Route::middleware('rol:0,1')->group(function () {
            Route::get('/create', [EquipoController::class, 'create'])->name('create');
            Route::post('/', [EquipoController::class, 'store'])->name('store');
        });

        Route::get('/{equipo}', [EquipoController::class, 'show'])->name('show');

        Route::middleware('rol:0,1')->group(function () {
            Route::get('/{equipo}/edit', [EquipoController::class, 'edit'])->name('edit');
            Route::put('/{equipo}', [EquipoController::class, 'update'])->name('update');
            Route::patch('/{equipo}', [EquipoController::class, 'update']);
            Route::delete('/{equipo}', [EquipoController::class, 'destroy'])->name('destroy');
        });
    });

    /* Modulos de ciclistas, pruebas y participaciones: solo admin y encargado */
    Route::middleware('rol:0,1')->group(function () {
        Route::resource('ciclista', CiclistaController::class);
        Route::resource('prueba', PruebaController::class);
        Route::resource('participa', ParticipaController::class);
        Route::patch('participa/{id}/estado', [ParticipaController::class, 'toggleEstado'])->name('participa.estado');
    });

    /* Modulo de ganadores: exclusivo para el administrador */
    Route::middleware('rol:0')->group(function () {
        Route::get('ganador', [GanadorController::class, 'index'])->name('ganador.index');
        Route::get('ganador/create', [GanadorController::class, 'create'])->name('ganador.create');
        Route::post('ganador', [GanadorController::class, 'store'])->name('ganador.store');
    });
});

