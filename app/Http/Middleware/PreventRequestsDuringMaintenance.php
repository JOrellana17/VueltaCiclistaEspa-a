<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /* URIs accesibles incluso cuando la aplicacion esta en modo mantenimiento */
    protected $except = [
        //
    ];
}
