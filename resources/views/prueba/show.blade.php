@extends('layouts.app')

@section('title', 'Detalle de la prueba | Vuelta Ciclista Espana')
@section('eyebrow', 'Ficha de prueba')
@section('page_title', 'Detalle de la prueba')

@section('content')
    <section class="detail-grid">
        <article class="detail-card">
            <div>
                <h2 class="detail-title">{{ $prueba->nombre }}</h2>
                <p class="detail-subtitle">Resumen completo del registro de la prueba.</p>
            </div>

            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>{{ $prueba->id }}</strong>
                </div>
                <div class="detail-item">
                    <span>Numero de etapas</span>
                    <strong>{{ $prueba->numero_etapas }}</strong>
                </div>
                <div class="detail-item">
                    <span>Ano de edicion</span>
                    <strong>{{ $prueba->anio_edicion }}</strong>
                </div>
                <div class="detail-item">
                    <span>Kilometros totales</span>
                    <strong>{{ $prueba->km_totales }}</strong>
                </div>
                <div class="detail-item">
                    <span>Estado</span>
                    <strong>{{ ucfirst($prueba->estado) }}</strong>
                </div>
            </div>
        </article>

        <aside class="detail-card">
            <div>
                <h2 class="detail-title">Acciones rapidas</h2>
                <p class="detail-subtitle">Edita la prueba, vuelve al listado o elimina el registro actual.</p>
            </div>

            <div class="form-actions">
                <a class="button-primary" href="{{ route('prueba.edit', $prueba->id) }}">Editar prueba</a>
                <a class="button-secondary" href="{{ route('ganador.create', ['id_prueba' => $prueba->id]) }}">Asignar ganador</a>
                <a class="button-secondary" href="{{ route('prueba.index') }}">Volver al listado</a>
            </div>

            <form action="{{ route('prueba.destroy', $prueba->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="button-danger" type="submit">Eliminar registro</button>
            </form>
        </aside>
    </section>
@endsection
