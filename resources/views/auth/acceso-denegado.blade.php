@extends('layouts.app')

@section('title', 'Acceso denegado | Vuelta Ciclista Espana')
@section('eyebrow', 'Control de acceso')
@section('page_title', 'Area restringida')

@section('content')
    <section class="section-card">
        <div class="acceso-denegado-section">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="56" height="56" style="color: var(--accent-dark); opacity: 0.7">
                <circle cx="12" cy="12" r="10"/>
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
            </svg>

            <div>
                <h2 class="detail-title" style="margin-bottom: 0.75rem">No tienes acceso a este modulo</h2>
                <p class="confirm-copy">Tu nivel de usuario no tiene permiso para ver esta seccion. Si necesitas acceso adicional, contacta al administrador del sistema.</p>
            </div>

            <a class="button-primary" href="{{ url('/') }}">Volver al inicio</a>
        </div>
    </section>
@endsection
