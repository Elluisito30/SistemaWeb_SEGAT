<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('logueo.login');
    }

    public function verificalogin(Request $request)
    {
        $data = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Ingrese correo',
                'email.email' => 'El correo no es válido',
                'password.required' => 'Ingrese contraseña'
            ]
        );

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas'
        ])->withInput();
    }

    public function salir()
    {
        Auth::logout();
        return redirect('/');
    }
}