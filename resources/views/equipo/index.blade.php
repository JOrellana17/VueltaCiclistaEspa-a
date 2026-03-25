@extends('layouts.app')

@section('title', 'Equipos | Vuelta Ciclista Espana')
@section('eyebrow', 'Modulo de equipos')
@section('page_title', 'Escuadras registradas')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Listado de equipos</h2>
                <p>Consulta todas las escuadras disponibles y actua sobre cada una desde la misma tabla.</p>
            </div>
            @if ((int) session('tipo_usuario') !== 2)
                <a class="button-primary" href="{{ route('equipo.create') }}">Nuevo equipo</a>
            @endif
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Director</th>
                        <th>Nacionalidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($equipos as $equipo)
                        <tr>
                            <td>{{ $equipo->id_equipo }}</td>
                            <td>{{ $equipo->nombre }}</td>
                            <td>{{ $equipo->director }}</td>
                            <td>{{ $equipo->nacionalidad?->nombre ?? 'Sin nacionalidad' }}</td>
                            <td>{{ ucfirst($equipo->estado) }}</td>
                            <td>
                                <div class="action-row">
                                    <a class="button-link" href="{{ route('equipo.show', $equipo->id_equipo) }}">Ver</a>
                                    @if ((int) session('tipo_usuario') !== 2)
                                        <a class="button-secondary" href="{{ route('equipo.edit', $equipo->id_equipo) }}">Editar</a>
                                        <form action="{{ route('equipo.destroy', $equipo->id_equipo) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="button-danger" type="submit" @disabled($equipo->estado === 'inactivo')>Inactivar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <p class="empty-state">No hay equipos registrados todavia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
