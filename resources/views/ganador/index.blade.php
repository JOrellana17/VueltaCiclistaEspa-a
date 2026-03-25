@extends('layouts.app')

@section('title', 'Ganadores | Vuelta Ciclista Espana')
@section('eyebrow', 'Modulo de ganadores')
@section('page_title', 'Asignacion de ganadores por prueba')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Ganadores registrados</h2>
                <p>Consulta el ganador de cada prueba y actualizalo cuando sea necesario.</p>
            </div>
            @if ((int) session('tipo_usuario') === 0)
                <a class="button-primary" href="{{ route('ganador.create') }}">Asignar ganador</a>
            @endif
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Prueba</th>
                        <th>Estado prueba</th>
                        <th>Ganador</th>
                        <th>Equipo</th>
                        @if ((int) session('tipo_usuario') === 0)
                            <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ganadores as $ganador)
                        <tr>
                            <td>{{ $ganador->prueba?->nombre ?? 'Sin prueba' }}</td>
                            <td>{{ ucfirst($ganador->prueba?->estado ?? 'inactivo') }}</td>
                            <td>{{ $ganador->ciclista?->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $ganador->equipo?->nombre ?? 'Sin equipo' }}</td>
                            @if ((int) session('tipo_usuario') === 0)
                                <td>
                                    <a class="button-secondary" href="{{ route('ganador.create', ['id_prueba' => $ganador->id_prueba]) }}">Asignar/Actualizar</a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ (int) session('tipo_usuario') === 0 ? 5 : 4 }}">
                                <p class="empty-state">No hay pruebas disponibles para asignar ganadores.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
