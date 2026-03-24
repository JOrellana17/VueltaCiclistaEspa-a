<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /* Campos sensibles que no deben incluirse en los reportes de errores */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /* Registra los manejadores personalizados de excepciones y reportes */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
