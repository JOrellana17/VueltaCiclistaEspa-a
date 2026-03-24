<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /* URIs excluidas de la verificacion del token CSRF */
    protected $except = [
        //
    ];
}
