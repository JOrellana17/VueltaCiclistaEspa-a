@extends('layouts.app')

@section('title', 'Editar prueba | Vuelta Ciclista Espana')
@section('eyebrow', 'Edicion de pruebas')
@section('page_title', 'Actualizar prueba')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Edicion del registro</h2>
                <p>Revisa los valores actuales de la prueba antes de aplicar cambios.</p>
            </div>
            <a class="button-secondary" href="{{ route('prueba.index') }}">Volver al listado</a>
        </div>

        <form action="{{ route('prueba.update', $prueba->id) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="field field-full">
                <label for="nombre">Nombre</label>
                <input class="input-control" id="nombre" type="text" name="nombre" value="{{ old('nombre', $prueba->nombre) }}" maxlength="50" required>
            </div>

            <div class="field">
                <label for="numero_etapas">Numero de etapas</label>
                <input class="input-control" id="numero_etapas" type="number" name="numero_etapas" value="{{ old('numero_etapas', $prueba->numero_etapas) }}" required>
            </div>

            <div class="field">
                <label for="anio_edicion">Ano de edicion</label>
                <input class="input-control" id="anio_edicion" type="number" name="anio_edicion" value="{{ old('anio_edicion', $prueba->anio_edicion) }}" required>
            </div>

            <div class="field field-full">
                <label for="km_totales">Kilometros totales</label>
                <input class="input-control" id="km_totales" type="number" name="km_totales" value="{{ old('km_totales', $prueba->km_totales) }}" required>
            </div>

            <div class="field field-full">
                <label for="estado">Estado</label>
                <select class="input-control" id="estado" name="estado" required>
                    <option value="activo" @selected(old('estado', $prueba->estado) === 'activo')>Activo</option>
                    <option value="inactivo" @selected(old('estado', $prueba->estado) === 'inactivo')>Inactivo</option>
                </select>
            </div>

            <div class="field field-full">
                <div class="form-actions">
                    <a class="button-secondary" href="{{ route('prueba.index') }}">Cancelar</a>
                    <button class="button-primary" type="submit">Guardar cambios</button>
                </div>
            </div>
        </form>
    </section>
@endsection
