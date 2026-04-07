@extends('layouts.app')

@section('title', 'Mis pruebas | Vuelta Ciclista Espana')
@section('eyebrow', 'Panel personal')
@section('page_title', 'Mis pruebas y resultados')

@section('content')
    <section class="section-card">
        <div class="section-toolbar">
            <div>
                <h2>Pruebas de {{ $ciclista->nombre }}</h2>
                <p>Pruebas en las que ha participado tu equipo <strong>{{ $ciclista->equipo?->nombre ?? '—' }}</strong> y tus resultados.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Prueba</th>
                        <th>Edicion</th>
                        <th>Etapas</th>
                        <th>Km totales</th>
                        <th>Estado prueba</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ciclista->equipo?->participaciones ?? [] as $participa)
                        @if ($participa->prueba)
                            <tr>
                                <td>{{ $participa->prueba->nombre }}</td>
                                <td>{{ $participa->prueba->anio_edicion }}</td>
                                <td>{{ $participa->prueba->numero_etapas }}</td>
                                <td>{{ $participa->prueba->km_totales }} km</td>
                                <td>{{ ucfirst($participa->prueba->estado) }}</td>
                                <td>
                                    @if (in_array($participa->prueba->id, $victoriaIds, true))
                                        <span class="badge-campeon">Campeon</span>
                                    @else
                                        <span style="color:var(--page-muted)">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6">
                                <p class="empty-state">Tu equipo no tiene participaciones registradas todavia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
