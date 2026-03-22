<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Participa;
use App\Models\Prueba;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParticipaController extends Controller
{
    /* comentario en espanol */
    public function index()
    {
        $listaParticipas = Participa::with(['equipo', 'prueba'])->latest('id_participa')->get();
        return view('participa.index')->with('participas', $listaParticipas);
    }

    /* comentario en espanol */
    public function create()
    {
        $equipos = Equipo::where('estado', 'activo')->orderBy('nombre')->get();
        $pruebas = Prueba::where('estado', 'activo')->orderBy('nombre')->get();

        return view('participa.create', compact('equipos', 'pruebas'));
    }

    /* comentario en espanol */
    public function store(Request $request)
    {
        $request->validate([
            'id_equipo' => [
                'required',
                Rule::exists('equipos', 'id_equipo')->where(fn ($query) => $query->where('estado', 'activo')),
            ],
            'id_prueba' => [
                'required',
                Rule::exists('pruebas', 'id')->where(fn ($query) => $query->where('estado', 'activo')),
            ],
            'fecha_inicio' => 'required|date',
            'fin_contrato' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $participa = new Participa();
        $participa->id_equipo = $request->id_equipo;
        $participa->id_prueba = $request->id_prueba;
        $participa->fecha_inicio = $request->fecha_inicio;
        $participa->fin_contrato = $request->fin_contrato;
        $participa->estado = $request->estado;
        $participa->save();

        return redirect()->route('participa.index')->with('success', 'Participacion creada correctamente.');
    }

    /* comentario en espanol */
    public function show(string $id)
    {
        $participa = Participa::with(['equipo', 'prueba'])->find($id);

        if (!$participa) {
            return redirect()->route('participa.index')->with('error', 'Participacion no encontrada.');
        }

        return view('participa.show')->with('participa', $participa);
    }

    /* comentario en espanol */
    public function edit(string $id)
    {
        $participa = Participa::find($id);
        $equipos = Equipo::where('estado', 'activo')
            ->orWhere('id_equipo', $participa?->id_equipo)
            ->orderBy('nombre')
            ->get();
        $pruebas = Prueba::where('estado', 'activo')
            ->orWhere('id', $participa?->id_prueba)
            ->orderBy('nombre')
            ->get();

        if (!$participa) {
            return redirect()->route('participa.index')->with('error', 'Participacion no encontrada.');
        }

        return view('participa.edit', compact('participa', 'equipos', 'pruebas'));
    }

    /* comentario en espanol */
    public function update(Request $request, string $id)
    {
        $participa = Participa::find($id);

        if (!$participa) {
            return redirect()->route('participa.index')->with('error', 'Participacion no encontrada.');
        }

        $request->validate([
            'id_equipo' => [
                'required',
                Rule::exists('equipos', 'id_equipo')->where(
                    fn ($query) => $query
                        ->where('estado', 'activo')
                        ->orWhere('id_equipo', $participa->id_equipo)
                ),
            ],
            'id_prueba' => [
                'required',
                Rule::exists('pruebas', 'id')->where(
                    fn ($query) => $query
                        ->where('estado', 'activo')
                        ->orWhere('id', $participa->id_prueba)
                ),
            ],
            'fecha_inicio' => 'required|date',
            'fin_contrato' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $participa->id_equipo = $request->id_equipo;
        $participa->id_prueba = $request->id_prueba;
        $participa->fecha_inicio = $request->fecha_inicio;
        $participa->fin_contrato = $request->fin_contrato;
        $participa->estado = $request->estado;
        $participa->save();

        return redirect()->route('participa.index')->with('success', 'Participacion actualizada correctamente.');
    }

    /* comentario en espanol */
    public function destroy(string $id)
    {
        $participa = Participa::find($id);

        if (!$participa) {
            return redirect()->route('participa.index')->with('error', 'Participacion no encontrada.');
        }

        $participa->estado = 'inactivo';
        $participa->save();

        return redirect()->route('participa.index')->with('success', 'Participacion inhabilitada correctamente.');
    }

    /* comentario en espanol */
    public function toggleEstado(string $id)
    {
        $participa = Participa::find($id);

        if (!$participa) {
            return redirect()->route('participa.index')->with('error', 'Participacion no encontrada.');
        }

        $participa->estado = $participa->estado === 'activo' ? 'inactivo' : 'activo';
        $participa->save();

        $mensaje = $participa->estado === 'activo'
            ? 'Participacion habilitada correctamente.'
            : 'Participacion inhabilitada correctamente.';

        return redirect()->route('participa.index')->with('success', $mensaje);
    }
}
