@extends('layouts.app')

@section('title', 'Detalle de la participacion | Vuelta Ciclista Espana')
@section('eyebrow', 'Ficha de participacion')
@section('page_title', 'Detalle de la participacion')

@section('content')
    <section class="detail-grid">
        <article class="detail-card">
            <div>
                <h2 class="detail-title">Participacion #{{ $participa->id_participa }}</h2>
                <p class="detail-subtitle">Informacion principal del registro seleccionado.</p>
            </div>

            <div class="detail-list">
                <div class="detail-item">
                    <span>Equipo</span>
                    <strong>{{ $participa->equipo?->nombre ?? 'Sin equipo' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Prueba</span>
                    <strong>{{ $participa->prueba?->nombre ?? 'Sin prueba' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Fecha de inicio</span>
                    <strong>{{ $participa->fecha_inicio }}</strong>
                </div>
                <div class="detail-item">
                    <span>Fecha final</span>
                    <strong>{{ $participa->fin_contrato }}</strong>
                </div>
                <div class="detail-item">
                    <span>Estado</span>
                    <strong>{{ ucfirst($participa->estado) }}</strong>
                </div>
            </div>
        </article>

        <aside class="detail-card">
            <div>
                <h2 class="detail-title">Acciones rapidas</h2>
                <p class="detail-subtitle">Edita el registro o vuelve al listado general.</p>
            </div>

            <div class="form-actions">
                <a class="button-primary" href="{{ route('participa.edit', $participa->id_participa) }}">Editar participacion</a>
                <a class="button-secondary" href="{{ route('participa.index') }}">Volver al listado</a>
            </div>

            <form action="{{ route('participa.estado', $participa->id_participa) }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="button-danger" type="submit">
                    {{ $participa->estado === 'activo' ? 'Inhabilitar registro' : 'Habilitar registro' }}
                </button>
            </form>
        </aside>
    </section>
@endsection
