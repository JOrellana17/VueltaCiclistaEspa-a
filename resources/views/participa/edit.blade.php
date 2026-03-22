@extends('layouts.app')

@section('title', 'Editar participacion | Vuelta Ciclista Espana')
@section('eyebrow', 'Edicion de participaciones')
@section('page_title', 'Actualizar participacion')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Edicion del registro</h2>
                <p>Modifica la participacion manteniendo visibles todos los campos relevantes.</p>
            </div>
            <a class="button-secondary" href="{{ route('participa.index') }}">Volver al listado</a>
        </div>

        @if ($equipos->isEmpty() || $pruebas->isEmpty())
            <p class="empty-state">No hay suficientes registros relacionados para editar esta participacion.</p>
        @endif

        <form action="{{ route('participa.update', $participa->id_participa) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="id_equipo">Equipo</label>
                <select class="input-control" id="id_equipo" name="id_equipo" required>
                    <option value="">Selecciona un equipo</option>
                    @foreach ($equipos as $equipo)
                        <option value="{{ $equipo->id_equipo }}" @selected(old('id_equipo', $participa->id_equipo) == $equipo->id_equipo)>
                            {{ $equipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="id_prueba">Prueba</label>
                <select class="input-control" id="id_prueba" name="id_prueba" required>
                    <option value="">Selecciona una prueba</option>
                    @foreach ($pruebas as $prueba)
                        <option value="{{ $prueba->id }}" @selected(old('id_prueba', $participa->id_prueba) == $prueba->id)>
                            {{ $prueba->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input class="input-control" id="fecha_inicio" type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $participa->fecha_inicio) }}" required>
            </div>

            <div class="field">
                <label for="fin_contrato">Fin de contrato</label>
                <input class="input-control" id="fin_contrato" type="date" name="fin_contrato" value="{{ old('fin_contrato', $participa->fin_contrato) }}" required>
            </div>

            <div class="field">
                <label for="estado">Estado</label>
                <select class="input-control" id="estado" name="estado" required>
                    <option value="activo" @selected(old('estado', $participa->estado) === 'activo')>Activo</option>
                    <option value="inactivo" @selected(old('estado', $participa->estado) === 'inactivo')>Inactivo</option>
                </select>
            </div>

            <div class="field field-full">
                <div class="form-actions">
                    <a class="button-secondary" href="{{ route('participa.index') }}">Cancelar</a>
                    <button class="button-primary" type="submit" @disabled($equipos->isEmpty() || $pruebas->isEmpty())>Guardar cambios</button>
                </div>
            </div>
        </form>
    </section>
@endsection
