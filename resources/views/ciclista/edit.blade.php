@extends('layouts.app')

@section('title', 'Editar ciclista | Vuelta Ciclista Espana')
@section('eyebrow', 'Edicion de ciclistas')
@section('page_title', 'Actualizar ficha del ciclista')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Edicion de datos</h2>
                <p>Revisa los valores actuales antes de guardar los cambios del ciclista.</p>
            </div>
            <a class="button-secondary" href="{{ route('ciclista.index') }}">Volver al listado</a>
        </div>

        @if ($equipos->isEmpty())
            <p class="empty-state">No hay equipos disponibles para reasignar este ciclista.</p>
        @endif

        @if ($nacionalidades->isEmpty())
            <p class="empty-state">No hay nacionalidades disponibles en el catalogo.</p>
        @endif

        <form action="{{ route('ciclista.update', $ciclista->id_ciclistas) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="id_equipo">Equipo</label>
                <select class="input-control" id="id_equipo" name="id_equipo" required>
                    <option value="">Selecciona un equipo</option>
                    @foreach ($equipos as $equipo)
                        <option value="{{ $equipo->id_equipo }}" @selected(old('id_equipo', $ciclista->id_equipo) == $equipo->id_equipo)>
                            {{ $equipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="nombre">Nombre</label>
                <input class="input-control" id="nombre" type="text" name="nombre" value="{{ old('nombre', $ciclista->nombre) }}" maxlength="50" required>
            </div>

            <div class="field">
                <label for="id_nacionalidad">Nacionalidad</label>
                <select class="input-control" id="id_nacionalidad" name="id_nacionalidad" required>
                    <option value="">Selecciona una nacionalidad</option>
                    @foreach ($nacionalidades as $nacionalidad)
                        <option value="{{ $nacionalidad->id_nacionalidad }}" @selected(old('id_nacionalidad', $ciclista->id_nacionalidad) == $nacionalidad->id_nacionalidad)>
                            {{ $nacionalidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input class="input-control" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $ciclista->fecha_nacimiento) }}" required>
            </div>

            <div class="field">
                <label for="fecha_inicio_contrato">Fecha de inicio contrato</label>
                <input class="input-control" id="fecha_inicio_contrato" type="date" name="fecha_inicio_contrato" value="{{ old('fecha_inicio_contrato', $ciclista->fecha_inicio_contrato) }}" required>
            </div>

            <div class="field">
                <label for="fecha_fin_contrato">Fecha final contrato</label>
                <input class="input-control" id="fecha_fin_contrato" type="date" name="fecha_fin_contrato" value="{{ old('fecha_fin_contrato', $ciclista->fecha_fin_contrato) }}" required>
            </div>

            <div class="field">
                <label for="estado_contrato">Estado contrato</label>
                <select class="input-control" id="estado_contrato" name="estado_contrato" required>
                    <option value="activo" @selected(old('estado_contrato', $ciclista->estado_contrato) === 'activo')>Activo</option>
                    <option value="inactivo" @selected(old('estado_contrato', $ciclista->estado_contrato) === 'inactivo')>Inactivo</option>
                </select>
            </div>

            <div class="field">
                <label for="estado">Estado</label>
                <select class="input-control" id="estado" name="estado" required>
                    <option value="activo" @selected(old('estado', $ciclista->estado) === 'activo')>Activo</option>
                    <option value="inactivo" @selected(old('estado', $ciclista->estado) === 'inactivo')>Inactivo</option>
                </select>
            </div>

            <div class="field field-full">
                <div class="form-actions">
                    <a class="button-secondary" href="{{ route('ciclista.index') }}">Cancelar</a>
                    <button class="button-primary" type="submit" @disabled($equipos->isEmpty() || $nacionalidades->isEmpty())>Guardar cambios</button>
                </div>
            </div>
        </form>
    </section>
@endsection
