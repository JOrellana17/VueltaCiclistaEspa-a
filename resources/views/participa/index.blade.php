@extends('layouts.app')

@section('title', 'Participaciones | Vuelta Ciclista Espana')
@section('eyebrow', 'Modulo de participaciones')
@section('page_title', 'Participaciones activas')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Listado de participaciones</h2>
                <p>Accede a cada participacion y edita su informacion contractual desde una misma tabla.</p>
            </div>
            <a class="button-primary" href="{{ route('participa.create') }}">Nueva participacion</a>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipo</th>
                        <th>Prueba</th>
                        <th>Fecha de inicio</th>
                        <th>Fin de contrato</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($participas as $participa)
                        <tr>
                            <td>{{ $participa->id_participa }}</td>
                            <td>{{ $participa->equipo?->nombre ?? 'Sin equipo' }}</td>
                            <td>{{ $participa->prueba?->nombre ?? 'Sin prueba' }}</td>
                            <td>{{ $participa->fecha_inicio }}</td>
                            <td>{{ $participa->fin_contrato }}</td>
                            <td>{{ ucfirst($participa->estado) }}</td>
                            <td>
                                <div class="action-row">
                                    <a class="button-link" href="{{ route('participa.show', $participa->id_participa) }}">Ver</a>
                                    <a class="button-secondary" href="{{ route('participa.edit', $participa->id_participa) }}">Editar</a>
                                    <form action="{{ route('participa.estado', $participa->id_participa) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="button-danger" type="submit">
                                            {{ $participa->estado === 'activo' ? 'Inhabilitar' : 'Habilitar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <p class="empty-state">No hay participaciones registradas todavia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
