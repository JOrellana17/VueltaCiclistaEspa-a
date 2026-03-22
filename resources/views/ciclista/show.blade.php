@extends('layouts.app')

@section('title', 'Detalle del ciclista | Vuelta Ciclista Espana')
@section('eyebrow', 'Ficha de ciclista')
@section('page_title', 'Detalle del corredor')

@section('content')
    <section class="detail-grid">
        <article class="detail-card">
            <div>
                <h2 class="detail-title">{{ $ciclista->nombre }}</h2>
                <p class="detail-subtitle">Informacion completa del ciclista seleccionado.</p>
            </div>

            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>{{ $ciclista->id_ciclistas }}</strong>
                </div>
                <div class="detail-item">
                    <span>Equipo</span>
                    <strong>{{ $ciclista->equipo?->nombre ?? 'Sin equipo' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Nacionalidad</span>
                    <strong>{{ $ciclista->nacionalidad?->nombre ?? 'Sin nacionalidad' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Fecha de nacimiento</span>
                    <strong>{{ $ciclista->fecha_nacimiento }}</strong>
                </div>
                <div class="detail-item">
                    <span>Fecha de inicio contrato</span>
                    <strong>{{ $ciclista->fecha_inicio_contrato }}</strong>
                </div>
                <div class="detail-item">
                    <span>Fecha final contrato</span>
                    <strong>{{ $ciclista->fecha_fin_contrato }}</strong>
                </div>
                <div class="detail-item">
                    <span>Estado contrato</span>
                    <strong>{{ ucfirst($ciclista->estado_contrato) }}</strong>
                </div>
                <div class="detail-item">
                    <span>Estado</span>
                    <strong>{{ ucfirst($ciclista->estado) }}</strong>
                </div>
            </div>
        </article>

        <aside class="detail-card">
            <div>
                <h2 class="detail-title">Acciones rapidas</h2>
                <p class="detail-subtitle">Edita, elimina o vuelve al listado general.</p>
            </div>

            <div class="form-actions">
                <a class="button-primary" href="{{ route('ciclista.edit', $ciclista->id_ciclistas) }}">Editar ciclista</a>
                <a class="button-secondary" href="{{ route('ciclista.index') }}">Volver al listado</a>
            </div>

            <form action="{{ route('ciclista.destroy', $ciclista->id_ciclistas) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="button-danger" type="submit" @disabled($ciclista->estado === 'inactivo')>Inactivar registro</button>
            </form>
        </aside>
    </section>
@endsection
