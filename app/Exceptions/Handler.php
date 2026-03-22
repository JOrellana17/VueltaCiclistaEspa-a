<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /* comentario en espanol */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /* comentario en espanol */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
