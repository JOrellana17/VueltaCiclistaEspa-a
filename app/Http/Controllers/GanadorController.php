<?php

namespace App\Http\Controllers;

use App\Models\Ciclista;
use App\Models\Equipo;
use App\Models\Ganador;
use App\Models\Prueba;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GanadorController extends Controller
{
    /* comentario en espanol */
    public function index()
    {
        $ganadores = Ganador::with(['prueba', 'equipo', 'ciclista'])
            ->latest('id_ganador')
            ->get();

        return view('ganador.index', compact('ganadores'));
    }

    /* comentario en espanol */
    public function create(Request $request)
    {
        $pruebas = Prueba::where('estado', 'activo')->orderByDesc('anio_edicion')->get();
        $equipos = Equipo::where('estado', 'activo')->orderBy('nombre')->get();
        $ciclistas = Ciclista::where('estado', 'activo')->orderBy('nombre')->get();
        $selectedPrueba = $request->query('id_prueba');

        return view('ganador.create', compact('pruebas', 'equipos', 'ciclistas', 'selectedPrueba'));
    }

    /* comentario en espanol */
    public function store(Request $request)
    {
        $request->validate([
            'id_prueba' => [
                'required',
                Rule::exists('pruebas', 'id')->where(fn ($query) => $query->where('estado', 'activo')),
            ],
            'id_equipo' => [
                'required',
                Rule::exists('equipos', 'id_equipo')->where(fn ($query) => $query->where('estado', 'activo')),
            ],
            'id_ciclista' => [
                'required',
                Rule::exists('ciclistas', 'id_ciclistas')->where(
                    fn ($query) => $query
                        ->where('estado', 'activo')
                        ->where('id_equipo', $request->id_equipo)
                ),
            ],
        ]);

        Ganador::updateOrCreate(
            ['id_prueba' => $request->id_prueba],
            [
                'id_equipo' => $request->id_equipo,
                'id_ciclista' => $request->id_ciclista,
            ]
        );

        return redirect()->route('ganador.index')->with('success', 'Ganador asignado correctamente.');
    }
}
