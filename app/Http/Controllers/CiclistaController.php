<?php

namespace App\Http\Controllers;

use App\Models\Ciclista;
use App\Models\Equipo;
use App\Models\Nacionalidad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CiclistaController extends Controller
{
    /* Muestra el listado completo de ciclistas con su equipo y nacionalidad */
    public function index()
    {
        $listaCiclistas = Ciclista::with(['equipo', 'nacionalidad'])->orderBy('nombre')->get();
        return view('ciclista.index')->with('ciclistas', $listaCiclistas);
    }

    /* Carga el formulario para registrar un nuevo ciclista */
    public function create()
    {
        $equipos = Equipo::where('estado', 'activo')->orderBy('nombre')->get();
        $nacionalidades = Nacionalidad::orderBy('nombre')->get();

        return view('ciclista.create', compact('equipos', 'nacionalidades'));
    }

    /* Valida y guarda un nuevo ciclista en la base de datos */
    public function store(Request $request)
    {
        $request->validate([
            'id_equipo' => [
                'required',
                Rule::exists('equipos', 'id_equipo')->where(fn ($query) => $query->where('estado', 'activo')),
            ],
            'id_nacionalidad' => 'required|exists:nacionalidades,id_nacionalidad',
            'nombre' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'fecha_inicio_contrato' => 'required|date',
            'fecha_fin_contrato' => 'required|date|after_or_equal:fecha_inicio_contrato',
            'estado_contrato' => 'required|in:activo,inactivo',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $ciclista = new Ciclista();
        $ciclista->id_equipo = $request->id_equipo;
        $ciclista->id_nacionalidad = $request->id_nacionalidad;
        $ciclista->nombre = $request->nombre;
        $ciclista->fecha_nacimiento = $request->fecha_nacimiento;
        $ciclista->fecha_inicio_contrato = $request->fecha_inicio_contrato;
        $ciclista->fecha_fin_contrato = $request->fecha_fin_contrato;
        $ciclista->estado_contrato = $request->estado_contrato;
        $ciclista->estado = $request->estado;
        $ciclista->save();

        return redirect()->route('ciclista.index')->with('success', 'Ciclista creado correctamente.');
    }

    /* Muestra el detalle de un ciclista especifico */
    public function show(string $id)
    {
        $ciclista = Ciclista::with(['equipo', 'nacionalidad'])->find($id);

        if (!$ciclista) {
            return redirect()->route('ciclista.index')->with('error', 'Ciclista no encontrado.');
        }

        return view('ciclista.show')->with('ciclista', $ciclista);
    }

    /* Carga el formulario para editar un ciclista existente */
    public function edit(string $id)
    {
        $ciclista = Ciclista::find($id);
        $equipos = Equipo::where('estado', 'activo')
            ->orWhere('id_equipo', $ciclista?->id_equipo)
            ->orderBy('nombre')
            ->get();
        $nacionalidades = Nacionalidad::orderBy('nombre')->get();

        if (!$ciclista) {
            return redirect()->route('ciclista.index')->with('error', 'Ciclista no encontrado.');
        }

        return view('ciclista.edit', compact('ciclista', 'equipos', 'nacionalidades'));
    }

    /* Valida y actualiza los datos de un ciclista existente */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_equipo' => [
                'required',
                Rule::exists('equipos', 'id_equipo')->where(fn ($query) => $query->where('estado', 'activo')),
            ],
            'id_nacionalidad' => 'required|exists:nacionalidades,id_nacionalidad',
            'nombre' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'fecha_inicio_contrato' => 'required|date',
            'fecha_fin_contrato' => 'required|date|after_or_equal:fecha_inicio_contrato',
            'estado_contrato' => 'required|in:activo,inactivo',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $ciclista = Ciclista::find($id);

        if (!$ciclista) {
            return redirect()->route('ciclista.index')->with('error', 'Ciclista no encontrado.');
        }

        $ciclista->id_equipo = $request->id_equipo;
        $ciclista->id_nacionalidad = $request->id_nacionalidad;
        $ciclista->nombre = $request->nombre;
        $ciclista->fecha_nacimiento = $request->fecha_nacimiento;
        $ciclista->fecha_inicio_contrato = $request->fecha_inicio_contrato;
        $ciclista->fecha_fin_contrato = $request->fecha_fin_contrato;
        $ciclista->estado_contrato = $request->estado_contrato;
        $ciclista->estado = $request->estado;
        $ciclista->save();

        return redirect()->route('ciclista.index')->with('success', 'Ciclista actualizado correctamente.');
    }

    /* Marca un ciclista como inactivo en la base de datos */
    public function destroy(string $id)
    {
        $eliminado = Ciclista::find($id);

        if (!$eliminado) {
            return redirect()->route('ciclista.index')->with('error', 'Ciclista no encontrado.');
        }

        $eliminado->estado = 'inactivo';
        $eliminado->save();

        return redirect()->route('ciclista.index')->with('success', 'Ciclista inactivado correctamente.');
    }

  
}
