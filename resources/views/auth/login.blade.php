<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion | Vuelta Ciclista Espana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="login-shell">
        <div class="login-card">
            <h1 class="login-title">Login</h1>

            @if ($errors->has('credenciales'))
                <div class="login-error">{{ $errors->first('credenciales') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="login-field">
                    <label class="login-label" for="usuario">Usuario</label>
                    <input
                        class="login-input"
                        type="text"
                        id="usuario"
                        name="usuario"
                        value="{{ old('usuario') }}"
                        autocomplete="username"
                        autofocus
                    >
                    <svg class="login-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                </div>

                <div class="login-field">
                    <label class="login-label" for="password">Contrasena</label>
                    <input
                        class="login-input"
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                    >
                    <button class="login-eye" type="button" id="toggle-password" aria-label="Mostrar contrasena">
                        <svg id="icon-eye" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="icon-eye-off" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>

                <button class="login-submit" type="submit">Ingresar</button>
            </form>
        </div>
    </div>

    <script>
        const toggleBtn  = document.getElementById('toggle-password');
        const passInput  = document.getElementById('password');
        const iconEye    = document.getElementById('icon-eye');
        const iconEyeOff = document.getElementById('icon-eye-off');

        toggleBtn.addEventListener('click', () => {
            const visible = passInput.type === 'text';
            passInput.type        = visible ? 'password' : 'text';
            iconEye.style.display    = visible ? '' : 'none';
            iconEyeOff.style.display = visible ? 'none' : '';
        });
    </script>
</body>
</html>

