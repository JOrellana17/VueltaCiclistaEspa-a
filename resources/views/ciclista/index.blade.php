@extends('layouts.app')

@section('title', 'Ciclistas | Vuelta Ciclista Espana')
@section('eyebrow', 'Modulo de ciclistas')
@section('page_title', 'Peloton registrado')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Listado de ciclistas</h2>
                <p>Resumen completo de los ciclistas disponibles en la aplicacion.</p>
            </div>
            <a class="button-primary" href="{{ route('ciclista.create') }}">Nuevo ciclista</a>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipo</th>
                        <th>Nombre</th>
                        <th>Nacionalidad</th>
                        <th>Fecha de nacimiento</th>
                        <th>Inicio contrato</th>
                        <th>Fin contrato</th>
                        <th>Estado contrato</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ciclistas as $ciclista)
                        <tr>
                            <td>{{ $ciclista->id_ciclistas }}</td>
                            <td>{{ $ciclista->equipo?->nombre ?? 'Sin equipo' }}</td>
                            <td>{{ $ciclista->nombre }}</td>
                            <td>{{ $ciclista->nacionalidad?->nombre ?? 'Sin nacionalidad' }}</td>
                            <td>{{ $ciclista->fecha_nacimiento }}</td>
                            <td>{{ $ciclista->fecha_inicio_contrato }}</td>
                            <td>{{ $ciclista->fecha_fin_contrato }}</td>
                            <td>{{ ucfirst($ciclista->estado_contrato) }}</td>
                            <td>{{ ucfirst($ciclista->estado) }}</td>
                            <td>
                                <div class="action-row">
                                    <a class="button-link" href="{{ route('ciclista.show', $ciclista->id_ciclistas) }}">Ver</a>
                                    <a class="button-secondary" href="{{ route('ciclista.edit', $ciclista->id_ciclistas) }}">Editar</a>
                                    <form action="{{ route('ciclista.destroy', $ciclista->id_ciclistas) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button-danger" type="submit" @disabled($ciclista->estado === 'inactivo')>Inactivar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="empty-state">No hay ciclistas registrados todavia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
