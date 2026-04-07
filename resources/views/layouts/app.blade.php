<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vuelta Ciclista Espana')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark">VC</span>
                <span class="brand-copy">
                    <strong>Vuelta Ciclista Espana</strong>
                    <span>Panel de gestion deportiva</span>
                </span>
            </a>

            <nav class="site-nav">
                <a class="nav-chip {{ request()->path() === '/' ? 'is-active' : '' }}" href="{{ url('/') }}">Inicio</a>

                @if (in_array((int) session('tipo_usuario'), [0, 1], true))
                    <a class="nav-chip {{ request()->routeIs('ciclista.*') ? 'is-active' : '' }}" href="{{ route('ciclista.index') }}">Ciclistas</a>
                @endif

                @if (in_array((int) session('tipo_usuario'), [0, 1], true))
                    <a class="nav-chip {{ request()->routeIs('usuario.index') ? 'is-active' : '' }}" href="{{ route('usuario.index') }}">Usuarios</a>
                @endif

                @if ((int) session('tipo_usuario') !== 3)
                    <a class="nav-chip {{ request()->routeIs('equipo.*') ? 'is-active' : '' }}" href="{{ route('equipo.index') }}">Equipos</a>
                @endif

                @if (in_array((int) session('tipo_usuario'), [0, 1], true))
                    <a class="nav-chip {{ request()->routeIs('participa.*') ? 'is-active' : '' }}" href="{{ route('participa.index') }}">Participaciones</a>
                    <a class="nav-chip {{ request()->routeIs('prueba.*') ? 'is-active' : '' }}" href="{{ route('prueba.index') }}">Pruebas</a>
                @endif

                @if (in_array((int) session('tipo_usuario'), [0, 2], true))
                    <a class="nav-chip {{ request()->routeIs('ganador.*') ? 'is-active' : '' }}" href="{{ route('ganador.index') }}">Ganadores</a>
                @endif

                @if ((int) session('tipo_usuario') === 3)
                    <a class="nav-chip {{ request()->routeIs('usuario.*') ? 'is-active' : '' }}" href="{{ route('usuario.mis-pruebas') }}">Mis pruebas</a>
                @endif
            </nav>

            <div class="header-user">
                <span class="user-badge">{{ session('usuario_nombre') }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-logout" type="submit">Salir</button>
                </form>
            </div>
        </header>

        <main class="page-main">
            <section class="hero-card">
                <div>
                    <p class="eyebrow">@yield('eyebrow', 'Gestion de carrera')</p>
                    <h1>@yield('page_title', 'Centro de control de la Vuelta')</h1>
                </div>

                <aside class="hero-panel">
                    <span class="hero-kicker">Temporada</span>
                    <strong class="hero-value">{{ date('Y') }}</strong>
                </aside>
            </section>

            @if (session('success'))
                <div class="notice notice-success">
                    <strong>Operacion completada</strong>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="notice notice-error">
                    <strong>Operacion no completada</strong>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="notice notice-error">
                    <strong>Revisa los datos enviados</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
