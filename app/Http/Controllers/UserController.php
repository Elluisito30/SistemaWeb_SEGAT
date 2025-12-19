<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('logueo.login');
    }

    public function verificalogin(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                'email.required' => 'Ingrese correo',
                'email.email' => 'El correo no es válido',
                'password.required' => 'Ingrese contraseña'
            ]
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Redirigir según el rol
            switch ($user->role) {
                case 'gerente':
                    return redirect()->route('gerente.dashboard');
                case 'trabajador':
                    return redirect()->route('trabajador.dashboard');
                case 'ciudadano':
                    return redirect()->route('ciudadano.dashboard');
                default:
                    return redirect()->route('login');
            }
        }

        return back()->withErrors([
            'email' => 'Email o contraseña incorrectos',
        ])->withInput();
    }

    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('mensaje', 'Sesión cerrada correctamente');
    }
}