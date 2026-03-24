<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /* Mapeo entre modelos y sus politicas de autorizacion */
    protected $policies = [
        //
    ];

    /* Registra los servicios de autenticacion y autorizacion */
    public function boot(): void
    {
        //
    }
}
