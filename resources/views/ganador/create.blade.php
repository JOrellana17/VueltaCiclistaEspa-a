@extends('layouts.app')

@section('title', 'Asignar ganador | Vuelta Ciclista Espana')
@section('eyebrow', 'Alta de ganador')
@section('page_title', 'Seleccionar ganador de prueba activa')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Formulario de asignacion</h2>
                <p>El listado de ciclistas se filtra segun el equipo seleccionado.</p>
            </div>
            <a class="button-secondary" href="{{ route('ganador.index') }}">Volver al modulo</a>
        </div>

        @if ($pruebas->isEmpty() || $equipos->isEmpty() || $ciclistas->isEmpty())
            <p class="empty-state">Se requiere al menos una prueba activa, un equipo activo y un ciclista activo para continuar.</p>
        @endif

        <form action="{{ route('ganador.store') }}" method="POST" class="form-grid">
            @csrf

            <div class="field field-full">
                <label for="id_prueba">Prueba activa</label>
                <select class="input-control" id="id_prueba" name="id_prueba" required>
                    <option value="">Selecciona una prueba activa</option>
                    @foreach ($pruebas as $prueba)
                        <option value="{{ $prueba->id }}" @selected(old('id_prueba', $selectedPrueba) == $prueba->id)>
                            {{ $prueba->nombre }} ({{ $prueba->anio_edicion }})
                        </option>
                    @endforeach
                </select>
            </div>

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
                <label for="id_ciclista">Ciclista del equipo</label>
                <select class="input-control" id="id_ciclista" name="id_ciclista" required>
                    <option value="">Selecciona primero un equipo</option>
                    @foreach ($ciclistas as $ciclista)
                        <option value="{{ $ciclista->id_ciclistas }}" data-equipo="{{ $ciclista->id_equipo }}" @selected(old('id_ciclista') == $ciclista->id_ciclistas)>
                            {{ $ciclista->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field field-full">
                <div class="form-actions">
                    <a class="button-secondary" href="{{ route('ganador.index') }}">Cancelar</a>
                    <button class="button-primary" type="submit" @disabled($pruebas->isEmpty() || $equipos->isEmpty() || $ciclistas->isEmpty())>Guardar ganador</button>
                </div>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const equipoSelect = document.getElementById('id_equipo');
            const ciclistaSelect = document.getElementById('id_ciclista');
            const allOptions = Array.from(ciclistaSelect.querySelectorAll('option[data-equipo]'));
            const oldValue = '{{ old('id_ciclista') }}';

            function filtrarCiclistas() {
                const equipoId = equipoSelect.value;
                ciclistaSelect.innerHTML = '';

                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = equipoId ? 'Selecciona un ciclista' : 'Selecciona primero un equipo';
                ciclistaSelect.appendChild(placeholder);

                allOptions
                    .filter(option => option.dataset.equipo === equipoId)
                    .forEach(option => {
                        const clone = option.cloneNode(true);
                        if (oldValue && clone.value === oldValue) {
                            clone.selected = true;
                        }
                        ciclistaSelect.appendChild(clone);
                    });
            }

            equipoSelect.addEventListener('change', filtrarCiclistas);
            filtrarCiclistas();
        });
    </script>
@endsection
