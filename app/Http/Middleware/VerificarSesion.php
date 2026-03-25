<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/* Verifica que exista una sesion activa antes de permitir el acceso */
class VerificarSesion
{
    /* Redirige al login si el usuario no ha iniciado sesion */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
