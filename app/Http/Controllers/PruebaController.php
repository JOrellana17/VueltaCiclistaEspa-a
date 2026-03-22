<?php

namespace App\Http\Controllers;

use App\Models\Prueba;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    /* comentario en espanol */
    public function index()
    {
        $listaPruebas = Prueba::orderByDesc('anio_edicion')->get();
        return view('prueba.index')->with('pruebas', $listaPruebas);
    }

    /* comentario en espanol */
    public function create()
    {
        return view('prueba.create');
    }

    /* comentario en espanol */
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

    /* comentario en espanol */
    public function show(string $id)
    {
        $prueba = Prueba::find($id);

        if (!$prueba) {
            return redirect()->route('prueba.index')->with('error', 'Prueba no encontrada.');
        }

        return view('prueba.show')->with('prueba', $prueba);
    }

    /* comentario en espanol */
    public function edit(string $id)
    {
        $prueba = Prueba::find($id);

        if (!$prueba) {
            return redirect()->route('prueba.index')->with('error', 'Prueba no encontrada.');
        }

        return view('prueba.edit', compact('prueba'));
    }

    /* comentario en espanol */
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

    /* comentario en espanol */
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