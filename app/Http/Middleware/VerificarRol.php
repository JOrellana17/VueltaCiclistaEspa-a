<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/* Verifica que el tipo de usuario tenga permiso para acceder a la ruta */
class VerificarRol
{
    /* Redirige a acceso denegado si el rol no esta en la lista permitida */
    public function handle(Request $request, Closure $next, string ...$tipos): Response
    {
        $tipoActual = session('tipo_usuario');

        if ($tipoActual === null || !in_array((string) $tipoActual, $tipos, true)) {
            return redirect()->route('acceso.denegado');
        }

        return $next($request);
    }
}
