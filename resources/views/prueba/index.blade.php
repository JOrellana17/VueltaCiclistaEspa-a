@extends('layouts.app')

@section('title', 'Pruebas | Vuelta Ciclista Espana')
@section('eyebrow', 'Modulo de pruebas')
@section('page_title', 'Calendario y resultados')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Listado de pruebas</h2>
                <p>Visualiza la informacion clave de cada prueba y accede rapidamente a sus acciones.</p>
            </div>
            <div class="form-actions">
                <a class="button-secondary" href="{{ route('ganador.index') }}">Gestionar ganadores</a>
                <a class="button-primary" href="{{ route('prueba.create') }}">Nueva prueba</a>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Etapas</th>
                        <th>Edicion</th>
                        <th>Km totales</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pruebas as $prueba)
                        <tr>
                            <td>{{ $prueba->id }}</td>
                            <td>{{ $prueba->nombre }}</td>
                            <td>{{ $prueba->numero_etapas }}</td>
                            <td>{{ $prueba->anio_edicion }}</td>
                            <td>{{ $prueba->km_totales }}</td>
                            <td>{{ ucfirst($prueba->estado) }}</td>
                            <td>
                                <div class="action-row">
                                    <a class="button-link" href="{{ route('prueba.show', $prueba->id) }}">Ver</a>
                                    <a class="button-secondary" href="{{ route('prueba.edit', $prueba->id) }}">Editar</a>
                                    <a class="button-secondary" href="{{ route('ganador.create', ['id_prueba' => $prueba->id]) }}">Asignar ganador</a>
                                    <form action="{{ route('prueba.destroy', $prueba->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <p class="empty-state">No hay pruebas registradas todavia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
