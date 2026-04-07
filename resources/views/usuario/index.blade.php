@extends('layouts.app')

@section('title', 'Usuarios | Vuelta Ciclista Espana')
@section('eyebrow', 'Modulo de usuarios')
@section('page_title', 'Usuarios del sistema')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Listado de usuarios</h2>
                <p>Consulta todos los usuarios registrados en el sistema y su nivel de acceso.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Ciclista vinculado</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tipoLabels = [0 => 'Admin', 1 => 'Encargado', 2 => 'Organizador', 3 => 'Ciclista'];
                    @endphp
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->usuario }}</td>
                            <td>{{ $tipoLabels[$usuario->tipo_usuario] ?? 'Desconocido' }}</td>
                            <td>{{ $usuario->ciclista?->nombre ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <p class="empty-state">No hay usuarios registrados todavia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
