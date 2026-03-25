<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/* Controlador para el manejo del inicio y cierre de sesion */
class AuthController extends Controller
{
    /* Muestra el formulario de inicio de sesion */
    public function showLogin()
    {
        if (session()->has('usuario_id')) {
            return redirect('/');
        }

        return view('auth.login');
    }

    /* Valida las credenciales y abre la sesion del usuario autenticado */
    public function login(Request $request)
    {
        $request->validate([
            'usuario'  => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('usuario', $request->usuario)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return back()
                ->withErrors(['credenciales' => 'El usuario o la contrasena son incorrectos.'])
                ->withInput(['usuario' => $request->usuario]);
        }

        session()->regenerate();

        session([
            'usuario_id'     => $usuario->id,
            'usuario_nombre' => $usuario->usuario,
            'tipo_usuario'   => (int) $usuario->tipo_usuario,
        ]);

        return redirect('/');
    }

    /* Cierra la sesion activa y redirige al formulario de login */
    public function logout()
    {
        session()->flush();
        session()->regenerate(true);

        return redirect()->route('login');
    }
}
