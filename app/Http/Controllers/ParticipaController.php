<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Participa;
use App\Models\Prueba;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParticipaController extends Controller
{
    /* Muestra el listado de participaciones de equipos en pruebas */
    public function index()
    {
        $listaParticipas = Participa::with(['equipo', 'prueba'])->latest('id_participa')->get();
        return view('participa.index')->with('participas', $listaParticipas);
    }

    /* Carga el formulario para registrar una nueva participacion */
    public function create()
    {
        $equipos = Equipo::where('estado', 'activo')->orderBy('nombre')->get();
        $pruebas = Prueba::where('estado', 'activo')->orderBy('nombre')->get();

        return view('participa.create', compact('equipos', 'pruebas'));
    }

    /* Valida y guarda una nueva participacion en la base de datos */
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

    /* Muestra el detalle de una participacion especifica */
    public function show(string $id)
    {
        $participa = Participa::with(['equipo', 'prueba'])->find($id);

        if (!$participa) {
            return redirect()->route('participa.index')->with('error', 'Participacion no encontrada.');
        }

        return view('participa.show')->with('participa', $participa);
    }

    /* Carga el formulario para editar una participacion existente */
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

    /* Valida y actualiza los datos de una participacion existente */
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

    /* Marca una participacion como inactiva en la base de datos */
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

    /* Activa o desactiva el estado de una participacion */
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
