<?php

namespace App\Http\Controllers;

use App\Models\Prueba;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    /* Muestra el listado completo de pruebas ciclistas */
    public function index()
    {
        $listaPruebas = Prueba::orderByDesc('anio_edicion')->get();
        return view('prueba.index')->with('pruebas', $listaPruebas);
    }

    /* Carga el formulario para registrar una nueva prueba */
    public function create()
    {
        return view('prueba.create');
    }

    /* Valida y guarda una nueva prueba en la base de datos */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'numero_etapas' => 'required|integer',
            'anio_edicion' => 'required|integer|min:1900|max:2100',
            'km_totales' => 'required|integer',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $prueba = new Prueba();
        $prueba->nombre = $request->nombre;
        $prueba->numero_etapas = $request->numero_etapas;
        $prueba->anio_edicion = $request->anio_edicion;
        $prueba->km_totales = $request->km_totales;
        $prueba->estado = $request->estado;
        $prueba->save();

        return redirect()->route('prueba.index')->with('success', 'Prueba creada correctamente.');
    }

    /* Muestra el detalle de una prueba especifica */
    public function show(string $id)
    {
        $prueba = Prueba::find($id);

        if (!$prueba) {
            return redirect()->route('prueba.index')->with('error', 'Prueba no encontrada.');
        }

        return view('prueba.show')->with('prueba', $prueba);
    }

    /* Carga el formulario para editar una prueba existente */
    public function edit(string $id)
    {
        $prueba = Prueba::find($id);

        if (!$prueba) {
            return redirect()->route('prueba.index')->with('error', 'Prueba no encontrada.');
        }

        return view('prueba.edit', compact('prueba'));
    }

    /* Valida y actualiza los datos de una prueba existente */
    public function update(Request $request, string $id)
    {
        $prueba = Prueba::find($id);

        if (!$prueba) {
            return redirect()->route('prueba.index')->with('error', 'Prueba no encontrada.');
        }

        $request->validate([
            'nombre' => 'required|string|max:50',
            'numero_etapas' => 'required|integer',
            'anio_edicion' => 'required|integer|min:1900|max:2100',
            'km_totales' => 'required|integer',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $prueba->nombre = $request->nombre;
        $prueba->numero_etapas = $request->numero_etapas;
        $prueba->anio_edicion = $request->anio_edicion;
        $prueba->km_totales = $request->km_totales;
        $prueba->estado = $request->estado;
        $prueba->save();

        return redirect()->route('prueba.index')->with('success', 'Prueba actualizada correctamente.');
    }

    /* Elimina una prueba de la base de datos */
    public function destroy(string $id)
    {
        $eliminado = Prueba::find($id);

        if (!$eliminado) {
            return redirect()->route('prueba.index')->with('error', 'Prueba no encontrada.');
        }

        $eliminado->delete();

        return redirect()->route('prueba.index')->with('success', 'Prueba eliminada correctamente.');
    }
}