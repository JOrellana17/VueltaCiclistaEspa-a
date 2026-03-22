@extends('layouts.app')

@section('title', 'Editar equipo | Vuelta Ciclista Espana')
@section('eyebrow', 'Edicion de equipos')
@section('page_title', 'Actualizar datos del equipo')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Edicion del equipo</h2>
                <p>Actualiza la ficha de la escuadra sin perder de vista sus datos principales.</p>
            </div>
            <a class="button-secondary" href="{{ route('equipo.index') }}">Volver al listado</a>
        </div>

        <form action="{{ route('equipo.update', $equipo->id_equipo) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="nombre">Nombre</label>
                <input class="input-control" id="nombre" type="text" name="nombre" value="{{ old('nombre', $equipo->nombre) }}" maxlength="50" required>
            </div>

            <div class="field">
                <label for="director">Director</label>
                <input class="input-control" id="director" type="text" name="director" value="{{ old('director', $equipo->director) }}" maxlength="50" required>
            </div>

            <div class="field">
                <label for="id_nacionalidad">Nacionalidad</label>
                <select class="input-control" id="id_nacionalidad" name="id_nacionalidad" required>
                    <option value="">Selecciona una nacionalidad</option>
                    @foreach ($nacionalidades as $nacionalidad)
                        <option value="{{ $nacionalidad->id_nacionalidad }}" @selected(old('id_nacionalidad', $equipo->id_nacionalidad) == $nacionalidad->id_nacionalidad)>
                            {{ $nacionalidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="estado">Estado</label>
                <select class="input-control" id="estado" name="estado" required>
                    <option value="activo" @selected(old('estado', $equipo->estado) === 'activo')>Activo</option>
                    <option value="inactivo" @selected(old('estado', $equipo->estado) === 'inactivo')>Inactivo</option>
                </select>
            </div>

            <div class="field field-full">
                <div class="form-actions">
                    <a class="button-secondary" href="{{ route('equipo.index') }}">Cancelar</a>
                    <button class="button-primary" type="submit">Guardar cambios</button>
                </div>
            </div>
        </form>
    </section>
@endsection
