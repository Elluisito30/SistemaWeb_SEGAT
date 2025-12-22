<?php

namespace App\Http\Controllers;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function dashboard()
    {
        return view('vistasHome.homeTrabajador');
    }

    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $trabajadores = Trabajador::where('nombres', 'like', '%'.$buscarpor.'%')
            ->orWhere('apellidos', 'like', '%'.$buscarpor.'%')
            ->paginate($this::PAGINATION);

        return view('mantenedor.gerente.trabajador.index', compact('trabajadores', 'buscarpor'));
    }

    public function create()
    {
        return view('mantenedor.gerente.trabajador.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|max:80|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|max:80|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'edad' => 'required|integer|min:18|max:100|digits_between:1,3',
            'email' => 'required|email|max:100|unique:trabajadores,email',
            'sexo' => 'required|in:Masculino,Femenino',
            'estado_civil' => 'required|in:Soltero,Casado,Viudo,Divorciado',
        ],
        [
            'nombres.required' => 'Ingrese nombres del trabajador',
            'nombres.max' => 'Máximo 80 caracteres para nombres',
            'nombres.regex' => 'Solo se permiten letras en el nombre',

            'apellidos.required' => 'Ingrese apellidos del trabajador',
            'apellidos.max' => 'Máximo 80 caracteres para los apellidos',
            'apellidos.regex' => 'Solo se permiten letras en los apellidos',

            'edad.required' => 'Ingrese la edad del trabajador',
            'edad.integer' => 'La edad debe ser un número entero',
            'edad.min' => 'La edad mínima es 18 años',
            'edad.max' => 'La edad máxima es 100 años',
            'edad.digits_between' => 'La edad debe tener entre 1 y 3 dígitos',

            'email.required' => 'Ingrese el email del trabajador',
            'email.email' => 'Ingrese un email válido',
            'email.unique' => 'Este email ya está registrado',

            'sexo.required' => 'Seleccione el sexo del trabajador',
            'sexo.in' => 'El sexo debe ser Masculino o Femenino',

            'estado_civil.required' => 'Seleccione el estado civil del trabajador',
            'estado_civil.in' => 'El estado civil debe ser Soltero, Casado, Viudo o Divorciado',
        ]);

        $trabajador = new Trabajador();
        $trabajador->nombres = $request->nombres;
        $trabajador->apellidos = $request->apellidos;
        $trabajador->edad = $request->edad;
        $trabajador->email = $request->email;
        $trabajador->sexo = $request->sexo;
        $trabajador->estado_civil = $request->estado_civil;
        $trabajador->save();

        return redirect()->route('trabajador.index')->with('datos', 'Trabajador registrado exitosamente');
    }

    public function edit(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('mantenedor.gerente.trabajador.edit', compact('trabajador'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombres' => 'required|max:80|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|max:80|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'edad' => 'required|integer|min:18|max:100|digits_between:1,3',
            'email' => 'required|email|max:100|unique:trabajadores,email,'.$id.',idtrabajador',
            'sexo' => 'required|in:Masculino,Femenino',
            'estado_civil' => 'required|in:Soltero,Casado,Viudo,Divorciado',
        ],
        [
            'nombres.required' => 'Ingrese nombres del trabajador',
            'nombres.max' => 'Máximo 80 caracteres para nombres',
            'nombres.regex' => 'Solo se permiten letras en el nombre',

            'apellidos.required' => 'Ingrese apellidos del trabajador',
            'apellidos.max' => 'Máximo 80 caracteres para los apellidos',
            'apellidos.regex' => 'Solo se permiten letras en los apellidos',

            'edad.required' => 'Ingrese la edad del trabajador',
            'edad.integer' => 'La edad debe ser un número entero',
            'edad.min' => 'La edad mínima es 18 años',
            'edad.max' => 'La edad máxima es 100 años',
            'edad.digits_between' => 'La edad debe tener entre 1 y 3 dígitos',

            'email.required' => 'Ingrese el email del trabajador',
            'email.email' => 'Ingrese un email válido',
            'email.unique' => 'Este email ya está registrado',

            'sexo.required' => 'Seleccione el sexo del trabajador',
            'sexo.in' => 'El sexo debe ser Masculino o Femenino',

            'estado_civil.required' => 'Seleccione el estado civil del trabajador',
            'estado_civil.in' => 'El estado civil debe ser Soltero, Casado, Viudo o Divorciado',
        ]);

        $trabajador = Trabajador::findOrFail($id);
        $trabajador->nombres = $request->nombres;
        $trabajador->apellidos = $request->apellidos;
        $trabajador->edad = $request->edad;
        $trabajador->email = $request->email;
        $trabajador->sexo = $request->sexo;
        $trabajador->estado_civil = $request->estado_civil;
        $trabajador->save();

        return redirect()->route('trabajador.index')->with('datos', 'Trabajador actualizado correctamente');
    }

    public function confirmar($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('mantenedor.gerente.trabajador.confirmar', compact('trabajador'));
    }

    public function destroy(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $trabajador->delete();
        return redirect()->route('trabajador.index')->with('datos', 'Trabajador eliminado correctamente');
    }
}