<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Nacionalidad;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /* Muestra el listado completo de equipos con su nacionalidad */
    public function index()
    {
        $listaEquipos = Equipo::with('nacionalidad')->orderBy('nombre')->get();
        return view('equipo.index')->with('equipos', $listaEquipos);
    }

    /* Carga el formulario para registrar un nuevo equipo */
    public function create()
    {
        $nacionalidades = Nacionalidad::orderBy('nombre')->get();

        return view('equipo.create', compact('nacionalidades'));
    }

    /* Valida y guarda un nuevo equipo en la base de datos */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'director' => 'required|string|max:50',
            'id_nacionalidad' => 'required|exists:nacionalidades,id_nacionalidad',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $equipo = new Equipo();
        $equipo->nombre = $request->nombre;
        $equipo->director = $request->director;
        $equipo->id_nacionalidad = $request->id_nacionalidad;
        $equipo->estado = $request->estado;
        $equipo->save();

        return redirect()->route('equipo.index')->with('success', 'Equipo creado correctamente.');
    }

    /* Muestra el detalle de un equipo y sus ciclistas asignados */
    public function show(string $id)
    {
        $equipo = Equipo::with(['nacionalidad', 'ciclistas.nacionalidad'])->find($id);

        if (!$equipo) {
            return redirect()->route('equipo.index')->with('error', 'Equipo no encontrado.');
        }

        return view('equipo.show')->with('equipo', $equipo);
    }

    /* Carga el formulario para editar un equipo existente */
    public function edit(string $id)
    {
        $equipo = Equipo::find($id);
        $nacionalidades = Nacionalidad::orderBy('nombre')->get();

        if (!$equipo) {
            return redirect()->route('equipo.index')->with('error', 'Equipo no encontrado.');
        }

        return view('equipo.edit', compact('equipo', 'nacionalidades'));
    }

    /* Valida y actualiza los datos de un equipo existente */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'director' => 'required|string|max:50',
            'id_nacionalidad' => 'required|exists:nacionalidades,id_nacionalidad',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $equipo = Equipo::find($id);

        if (!$equipo) {
            return redirect()->route('equipo.index')->with('error', 'Equipo no encontrado.');
        }

        $equipo->nombre = $request->nombre;
        $equipo->director = $request->director;
        $equipo->id_nacionalidad = $request->id_nacionalidad;
        $equipo->estado = $request->estado;
        $equipo->save();

        return redirect()->route('equipo.index')->with('success', 'Equipo actualizado correctamente.');
    }

    /* Marca un equipo como inactivo en la base de datos */
    public function destroy(string $id)
    {
        $eliminado = Equipo::find($id);

        if (!$eliminado) {
            return redirect()->route('equipo.index')->with('error', 'Equipo no encontrado.');
        }

        $eliminado->estado = 'inactivo';
        $eliminado->save();

        return redirect()->route('equipo.index')->with('success', 'Equipo inactivado correctamente.');
    }

}
