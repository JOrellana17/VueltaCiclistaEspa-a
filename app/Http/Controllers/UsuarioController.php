<?php

namespace App\Http\Controllers;

use App\Models\Ciclista;
use App\Models\Ganador;
use App\Models\Usuario;

/* Controlador para las pantallas personales del usuario tipo ciclista */
class UsuarioController extends Controller
{
    /* Muestra el listado completo de usuarios del sistema */
    public function index()
    {
        $usuarios = Usuario::with('ciclista')->orderBy('tipo_usuario')->get();
        return view('usuario.index', compact('usuarios'));
    }

    /* Muestra las pruebas del equipo del ciclista autenticado y sus victorias */
    public function misPruebas()
    {
        $ciclistaId = session('id_ciclista');

        if (!$ciclistaId) {
            return redirect('/')->with('error', 'No hay ciclista vinculado a este usuario.');
        }

        $ciclista = Ciclista::with(['equipo.participaciones.prueba'])->find($ciclistaId);

        if (!$ciclista) {
            return redirect('/')->with('error', 'Ciclista no encontrado.');
        }

        $victorias = Ganador::with('prueba')
            ->where('id_ciclista', $ciclistaId)
            ->get();

        $victoriaIds = $victorias->pluck('id_prueba')->toArray();

        return view('usuario.mis-pruebas', compact('ciclista', 'victorias', 'victoriaIds'));
    }
}
