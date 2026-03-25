@extends('layouts.app')

@section('title', 'Inicio | Vuelta Ciclista Espana')
@section('eyebrow', 'Panel principal')
@section('page_title', 'Administracion de la Vuelta Ciclista')

@section('content')
    <section class="dashboard-grid">
        @if ((int) session('tipo_usuario') !== 2)
            <a class="dashboard-card" href="{{ route('ciclista.index') }}">
                <span class="dashboard-tag">Ciclistas</span>
                <h2>Gestion del peloton</h2>
                <p>Alta, consulta y mantenimiento de corredores con sus datos clave y referencias de equipo.</p>
                <span class="dashboard-link">Abrir modulo</span>
            </a>
        @endif

        <a class="dashboard-card" href="{{ route('equipo.index') }}">
            <span class="dashboard-tag">Equipos</span>
            <h2>Estructura deportiva</h2>
            <p>Centraliza directores, nacionalidades y composicion general de cada escuadra.</p>
            <span class="dashboard-link">Abrir modulo</span>
        </a>

        @if ((int) session('tipo_usuario') !== 2)
            <a class="dashboard-card" href="{{ route('participa.index') }}">
                <span class="dashboard-tag">Participaciones</span>
                <h2>Inscripciones y participaciones</h2>
                <p>Consulta altas por prueba y controla el rango temporal de cada participacion.</p>
                <span class="dashboard-link">Abrir modulo</span>
            </a>

            <a class="dashboard-card" href="{{ route('prueba.index') }}">
                <span class="dashboard-tag">Pruebas</span>
                <h2>Calendario de la competicion</h2>
                <p>Gestiona ediciones, kilometraje total y resultados historicos desde una sola vista.</p>
                <span class="dashboard-link">Abrir modulo</span>
            </a>
        @endif

        @if (in_array((int) session('tipo_usuario'), [0, 2], true))
            <a class="dashboard-card" href="{{ route('ganador.index') }}">
                <span class="dashboard-tag">Ganadores</span>
                @if ((int) session('tipo_usuario') === 0)
                    <h2>Asignacion de ganador</h2>
                    <p>Elige prueba activa, equipo y ciclista del equipo para registrar al ganador oficial.</p>
                @else
                    <h2>Consulta de ganadores</h2>
                    <p>Visualiza los ganadores registrados por prueba en modo solo lectura.</p>
                @endif
                <span class="dashboard-link">Abrir modulo</span>
            </a>
        @endif
    </section>
@endsection
