<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    // Mostrar el formulario de registro
    public function showRegistrationForm()
    {
        return view('logueo.registro');
    }

    // Procesar el registro
    public function verificarRegistro(Request $request)
    {
        // Validar los datos
        $data = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'name.required' => 'El nombre es obligatorio',
                'email.required' => 'El correo es obligatorio',
                'email.email' => 'El correo no es válido',
                'email.unique' => 'Este correo ya está registrado',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
            ]
        );

        // Crear el usuario con rol ciudadano
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'ciudadano', // Siempre será ciudadano
        ]);

        // Autenticar automáticamente al usuario
        Auth::login($user);

        // Redirigir al dashboard del ciudadano
        return redirect()->route('ciudadano.dashboard')->with('mensaje', '¡Registro exitoso! Bienvenido a SEGAT.');
    }
}