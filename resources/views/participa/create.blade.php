@extends('layouts.app')

@section('title', 'Crear participacion | Vuelta Ciclista Espana')
@section('eyebrow', 'Alta de participaciones')
@section('page_title', 'Registrar participacion')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Formulario de alta</h2>
                <p>Introduce la informacion principal para crear una nueva participacion.</p>
            </div>
            <a class="button-secondary" href="{{ route('participa.index') }}">Volver al listado</a>
        </div>

        @if ($equipos->isEmpty() || $pruebas->isEmpty())
            <p class="empty-state">Necesitas al menos un equipo y una prueba registrados para crear una participacion.</p>
        @endif

        <form action="{{ route('participa.store') }}" method="POST" class="form-grid">
            @csrf

            <div class="field">
                <label for="id_equipo">Equipo</label>
                <select class="input-control" id="id_equipo" name="id_equipo" required>
                    <option value="">Selecciona un equipo</option>
                    @foreach ($equipos as $equipo)
                        <option value="{{ $equipo->id_equipo }}" @selected(old('id_equipo') == $equipo->id_equipo)>
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
                        <option value="{{ $prueba->id }}" @selected(old('id_prueba') == $prueba->id)>
                            {{ $prueba->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input class="input-control" id="fecha_inicio" type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
            </div>

            <div class="field">
                <label for="fin_contrato">Fecha final</label>
                <input class="input-control" id="fin_contrato" type="date" name="fin_contrato" value="{{ old('fin_contrato') }}" required>
            </div>

            <div class="field">
                <label for="estado">Estado</label>
                <select class="input-control" id="estado" name="estado" required>
                    <option value="activo" @selected(old('estado', 'activo') === 'activo')>Activo</option>
                    <option value="inactivo" @selected(old('estado') === 'inactivo')>Inactivo</option>
                </select>
            </div>

            <div class="field field-full">
                <div class="form-actions">
                    <a class="button-secondary" href="{{ route('participa.index') }}">Cancelar</a>
                    <button class="button-primary" type="submit" @disabled($equipos->isEmpty() || $pruebas->isEmpty())>Guardar participacion</button>
                </div>
            </div>
        </form>
    </section>
@endsection
