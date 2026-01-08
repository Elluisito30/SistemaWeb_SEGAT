<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\User;
use App\Models\SolicitudLimpieza;
use App\Models\Infraccion;
use App\Models\RegistroInfraccion;
use App\Models\DetalleInfraccion;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TrabajadorController extends Controller
{
    const PAGINATION = 10;

    // ========================================
    // DASHBOARD
    // ========================================
    public function dashboard()
    {
        return view('vistasHome.homeTrabajador');
    }

    // ========================================
    // GESTIÓN DE SOLICITUDES DE LIMPIEZA
    // ========================================
    
    public function indexSolicitudes(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $estado = $request->get('estado');
        
        $solicitudes = SolicitudLimpieza::with([
                'detalleSolicitud.areaVerde',
                'detalleSolicitud.contribuyente',
                'servicio'
            ])
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->whereHas('detalleSolicitud.areaVerde', function ($q) use ($buscarpor) {
                    $q->where('nombre', 'like', '%' . $buscarpor . '%');
                });
            })
            ->when($estado, function ($query) use ($estado) {
                $query->where('estado', $estado);
            })
            ->orderBy('id_solicitud', 'desc')
            ->paginate(self::PAGINATION);

        return view('mantenedor.trabajador.solicitudes.index', compact('solicitudes', 'buscarpor', 'estado'));
    }

    public function editSolicitud($id)
    {
        $solicitud = SolicitudLimpieza::with([
            'detalleSolicitud.areaVerde',
            'detalleSolicitud.contribuyente',
            'servicio'
        ])->findOrFail($id);
        
        return view('mantenedor.trabajador.solicitudes.edit', compact('solicitud'));
    }

    public function updateSolicitud(Request $request, $id)
    {
        $solicitud = SolicitudLimpieza::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:registrada,en atención,atendida,rechazada',
            'monto' => 'nullable|numeric|min:0|max:99999.99',
            'fechaProgramada' => 'nullable|date'
        ], [
            'estado.required' => 'Seleccione un estado.',
            'estado.in' => 'Estado no válido.',
            'monto.numeric' => 'El monto debe ser numérico.',
            'monto.min' => 'El monto no puede ser negativo.',
            'monto.max' => 'El monto no puede exceder 99999.99',
            'fechaProgramada.date' => 'Formato de fecha no válido.'
        ]);

        $estadoAnterior = $solicitud->estado;

        // Actualizar campos según lo enviado
        $solicitud->estado = $request->estado;
        
        if ($request->monto) {
            $solicitud->monto = $request->monto;
        }
        
        if ($request->fechaProgramada) {
            $solicitud->fechaProgramada = $request->fechaProgramada;
        }

        $solicitud->save();

        // NOTIFICAR AL CIUDADANO 
        if ($estadoAnterior !== $solicitud->estado && $solicitud->detalleSolicitud->contribuyente->user_id) {
            $mensajes = [
                'en atención' => 'Su solicitud más reciente está siendo atendida por un trabajador.',
                'atendida' => 'Su solicitud más reciente ha sido atendida exitosamente.',
                'rechazada' => 'Su solicitud más reciente ha sido rechazada.'
            ];

            Notificacion::create([
                'user_id' => $solicitud->detalleSolicitud->contribuyente->user_id,
                'tipo' => 'solicitud',
                'titulo' => 'Actualización de solicitud',
                'mensaje' => 'Su solicitud ha sido actualizada.',
                'url' => route('ciudadano.solicitud.index')
            ]);
        }

        return redirect()->route('trabajador.solicitudes.index')
            ->with('datos', 'Solicitud actualizada exitosamente.');
    }

    // ========================================
    // GESTIÓN DE INFRACCIONES
    // ========================================
    
    public function indexInfracciones(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        
        $infracciones = Infraccion::with([
                'detalleInfraccion.contribuyente',
                'detalleInfraccion.tipo'
            ])
            ->whereDoesntHave('detalleInfraccion.registroInfraccion')
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->whereHas('detalleInfraccion.contribuyente', function ($q) use ($buscarpor) {
                    $q->where('numDocumento', 'like', '%' . $buscarpor . '%')
                      ->orWhere('email', 'like', '%' . $buscarpor . '%');
                });
            })
            ->orderBy('id_infraccion', 'desc')
            ->paginate(self::PAGINATION);

        return view('mantenedor.trabajador.infracciones.index', compact('infracciones', 'buscarpor'));
    }

    public function validarInfraccion($id)
    {
        $infraccion = Infraccion::with([
            'detalleInfraccion.contribuyente',
            'detalleInfraccion.tipo'
        ])->findOrFail($id);
        
        if ($infraccion->detalleInfraccion->registroInfraccion) {
            return redirect()->route('trabajador.infracciones.index')
                ->with('error', 'Esta infracción ya fue validada anteriormente.');
        }
        
        return view('mantenedor.trabajador.infracciones.validar', compact('infraccion'));
    }

    public function storeValidacion(Request $request, $id)
    {
        $infraccion = Infraccion::findOrFail($id);

        if ($infraccion->detalleInfraccion->registroInfraccion) {
            return redirect()->route('trabajador.infracciones.index')
                ->with('error', 'Esta infracción ya fue validada.');
        }

        $request->validate([
            'montoMulta' => 'required|numeric|min:0|max:99999.99',
            'fechaLimitePago' => 'required|date|after:today',
            'estadoPago' => 'required|in:Pendiente,Pagada,Vencida'
        ], [
            'montoMulta.required' => 'Ingrese el monto de la multa.',
            'montoMulta.numeric' => 'El monto debe ser numérico.',
            'montoMulta.min' => 'El monto no puede ser negativo.',
            'montoMulta.max' => 'El monto no puede exceder 99999.99',
            'fechaLimitePago.required' => 'Ingrese la fecha límite de pago.',
            'fechaLimitePago.date' => 'Formato de fecha no válido.',
            'fechaLimitePago.after' => 'La fecha límite debe ser posterior a hoy.',
            'estadoPago.required' => 'Seleccione el estado de pago.',
            'estadoPago.in' => 'Estado de pago no válido.'
        ]);

        try {
            DB::beginTransaction();

            $infraccion->montoMulta = $request->montoMulta;
            $infraccion->fechaLimitePago = $request->fechaLimitePago;
            $infraccion->estadoPago = $request->estadoPago;
            $infraccion->save();

            // Obtener trabajador del usuario logueado usando relación
            $trabajador = Auth::user()->trabajador;
            
            if (!$trabajador) {
                throw new \Exception('No se encontró trabajador asociado al usuario.');
            }

            RegistroInfraccion::create([
                'id_detalleInfraccion' => $infraccion->id_detalleInfraccion,
                'idtrabajador' => $trabajador->idtrabajador,
                'fechaHoraEmision' => now(),
                'estado' => 'Validada'
            ]);

            // NOTIFICAR AL CIUDADANO sobre la nueva multa
            if ($infraccion->detalleInfraccion->contribuyente->user_id) {
                Notificacion::create([
                    'user_id' => $infraccion->detalleInfraccion->contribuyente->user_id,
                    'tipo' => 'multa',
                    'titulo' => 'Nueva multa registrada',
                    'mensaje' => 'Se ha registrado una multa a su nombre por un monto de S/ ' . number_format($request->montoMulta, 2) . '.',
                    'url' => route('ciudadano.infracciones.index')
                ]);
            }

            DB::commit();

            return redirect()->route('trabajador.infracciones.index')
                ->with('datos', 'Infracción validada y multa registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al validar la infracción: ' . $e->getMessage());
        }
    }

    public function historialInfracciones(Request $request)
    {
        // Usar relación en lugar de buscar por email
        $trabajador = Auth::user()->trabajador;
        
        if (!$trabajador) {
            return redirect()->route('trabajador.dashboard')
                ->with('error', 'No se encontró trabajador asociado.');
        }

        $buscarpor = $request->get('buscarpor');
        
        $infracciones = RegistroInfraccion::with([
                'detalleInfraccion.infraccion',
                'detalleInfraccion.contribuyente',
                'detalleInfraccion.tipo'
            ])
            ->where('idtrabajador', $trabajador->idtrabajador)
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->whereHas('detalleInfraccion.contribuyente', function ($q) use ($buscarpor) {
                    $q->where('numDocumento', 'like', '%' . $buscarpor . '%')
                      ->orWhere('email', 'like', '%' . $buscarpor . '%');
                });
            })
            ->orderBy('fechaHoraEmision', 'desc')
            ->paginate(self::PAGINATION);

        return view('mantenedor.trabajador.infracciones.historial', compact('infracciones', 'buscarpor'));
    }

    // ========================================
    // CRUD DE TRABAJADORES (SOLO PARA GERENTE)
    // ========================================
    
    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $trabajadores = Trabajador::where('nombres', 'like', '%'.$buscarpor.'%')
            ->orWhere('apellidos', 'like', '%'.$buscarpor.'%')
            ->orWhere('email', 'like', '%'.$buscarpor.'%')
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
            'email' => 'required|email|max:100|unique:users,email',
            'sexo' => 'required|in:Masculino,Femenino',
            'estado_civil' => 'required|in:Soltero,Casado,Viudo,Divorciado',
            'password' => 'required|min:8|confirmed'
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
            'password.required' => 'Ingrese la contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden'
        ]);

        try {
            DB::beginTransaction();

            // 1. Crear usuario
            $user = new User();
            $user->name = $request->nombres . ' ' . $request->apellidos;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'trabajador';
            $user->save();

            // 2. Crear trabajador vinculado al usuario
            $trabajador = new Trabajador();
            $trabajador->user_id = $user->id;
            $trabajador->nombres = $request->nombres;
            $trabajador->apellidos = $request->apellidos;
            $trabajador->edad = $request->edad;
            $trabajador->email = $request->email;
            $trabajador->sexo = $request->sexo;
            $trabajador->estado_civil = $request->estado_civil;
            $trabajador->save();

            DB::commit();

            return redirect()->route('trabajador.index')->with('datos', 'Trabajador registrado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error al registrar trabajador: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('mantenedor.gerente.trabajador.edit', compact('trabajador'));
    }

    public function update(Request $request, string $id)
    {
        $trabajador = Trabajador::findOrFail($id);

        $data = $request->validate([
            'nombres' => 'required|max:80|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|max:80|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'edad' => 'required|integer|min:18|max:100|digits_between:1,3',
            'email' => 'required|email|max:100|unique:users,email,' . $trabajador->user_id,
            'sexo' => 'required|in:Masculino,Femenino',
            'estado_civil' => 'required|in:Soltero,Casado,Viudo,Divorciado',
            'password' => 'nullable|min:8|confirmed',
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
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar trabajador
            $trabajador->nombres = $request->nombres;
            $trabajador->apellidos = $request->apellidos;
            $trabajador->edad = $request->edad;
            $trabajador->email = $request->email;
            $trabajador->sexo = $request->sexo;
            $trabajador->estado_civil = $request->estado_civil;
            $trabajador->save();

            // Actualizar usuario relacionado
            if ($trabajador->user) {
                $trabajador->user->name = $request->nombres . ' ' . $request->apellidos;
                $trabajador->user->email = $request->email;
                
                // Actualizar contraseña si se proporciona
                if ($request->password) {
                    $trabajador->user->password = Hash::make($request->password);
                }
                
                $trabajador->user->save();
            }

            DB::commit();

            return redirect()->route('trabajador.index')->with('datos', 'Trabajador actualizado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar trabajador: ' . $e->getMessage());
        }
    }

    public function confirmar($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('mantenedor.gerente.trabajador.confirmar', compact('trabajador'));
    }

    public function destroy(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        // Al eliminar trabajador, también se elimina usuario (por CASCADE)
        $trabajador->delete();
        return redirect()->route('trabajador.index')->with('datos', 'Trabajador eliminado correctamente');
    }
}