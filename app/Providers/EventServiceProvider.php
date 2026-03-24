<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /* Mapeo entre eventos de la aplicacion y sus oyentes */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /* Registra los eventos y oyentes de la aplicacion */
    public function boot(): void
    {
        //
    }

    /* Indica si los eventos deben descubrirse automaticamente */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
