@extends('layouts.app')

@section('title', 'Detalle del equipo | Vuelta Ciclista Espana')
@section('eyebrow', 'Ficha de equipo')
@section('page_title', 'Detalle de la escuadra')

@section('content')
    <section class="detail-grid">
        <article class="detail-card">
            <div>
                <h2 class="detail-title">{{ $equipo->nombre }}</h2>
                <p class="detail-subtitle">Vista de detalle del equipo seleccionado.</p>
            </div>

            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>{{ $equipo->id_equipo }}</strong>
                </div>
                <div class="detail-item">
                    <span>Director</span>
                    <strong>{{ $equipo->director }}</strong>
                </div>
                <div class="detail-item">
                    <span>Nacionalidad</span>
                    <strong>{{ $equipo->nacionalidad?->nombre ?? 'Sin nacionalidad' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Estado</span>
                    <strong>{{ ucfirst($equipo->estado) }}</strong>
                </div>
            </div>
        </article>

        <aside class="detail-card">
            <div>
                <h2 class="detail-title">Acciones rapidas</h2>
                <p class="detail-subtitle">Edita el equipo, vuelve al listado o elimina el registro actual.</p>
            </div>

            <div class="form-actions">
                <a class="button-primary" href="{{ route('equipo.edit', $equipo->id_equipo) }}">Editar equipo</a>
                <a class="button-secondary" href="{{ route('equipo.index') }}">Volver al listado</a>
            </div>

            <form action="{{ route('equipo.destroy', $equipo->id_equipo) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="button-danger" type="submit" @disabled($equipo->estado === 'inactivo')>Inactivar registro</button>
            </form>
        </aside>
    </section>

    <section class="section-card section-spaced">
        <div class="section-toolbar">
            <div>
                <h2>Integrantes del equipo</h2>
                <p>Listado de ciclistas asignados actualmente a esta escuadra.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Nacionalidad</th>
                        <th>Inicio contrato</th>
                        <th>Fin contrato</th>
                        <th>Estado contrato</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($equipo->ciclistas as $integrante)
                        <tr>
                            <td>{{ $integrante->id_ciclistas }}</td>
                            <td>{{ $integrante->nombre }}</td>
                            <td>{{ $integrante->nacionalidad?->nombre ?? 'Sin nacionalidad' }}</td>
                            <td>{{ $integrante->fecha_inicio_contrato }}</td>
                            <td>{{ $integrante->fecha_fin_contrato }}</td>
                            <td>{{ ucfirst($integrante->estado_contrato) }}</td>
                            <td>{{ ucfirst($integrante->estado) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <p class="empty-state">Este equipo todavia no tiene ciclistas asignados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
