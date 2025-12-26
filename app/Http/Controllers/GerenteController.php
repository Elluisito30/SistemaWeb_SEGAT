<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\SolicitudLimpieza;
use App\Models\Infraccion;
use Illuminate\Support\Facades\DB;

class GerenteController extends Controller
{
    public function dashboard()
    {
        $totalTrabajadores = Trabajador::count();
        $totalSolicitudes = SolicitudLimpieza::count();
        $totalInfracciones = Infraccion::count();

        $solicitudesPorEstado = SolicitudLimpieza::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')->pluck('total', 'estado')->toArray();

        $estadosGrafico = ['registrada', 'en atención', 'atendida', 'rechazado'];
        $dataSolicitudes = [];

        foreach ($estadosGrafico as $estado) {
            $cantidad = 0;
            foreach ($solicitudesPorEstado as $key => $val) {
                if (mb_strtolower($key, 'UTF-8') == $estado) $cantidad += $val;
            }
            $dataSolicitudes[] = $cantidad;
        }
        $labelsGrafico = ['Registrada', 'En Atención', 'Atendida', 'Rechazado'];

        $ultimasSolicitudes = SolicitudLimpieza::orderBy('id_solicitud', 'desc')->take(5)->get();
        $ultimasInfracciones = Infraccion::orderBy('id_infraccion', 'desc')->take(5)->get();

        return view('vistasHome.homeGerente', compact(
            'totalTrabajadores', 'totalSolicitudes', 'totalInfracciones',
            'labelsGrafico', 'dataSolicitudes', 'ultimasSolicitudes', 'ultimasInfracciones'
        ));
    }


    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $trabajadores = Trabajador::where('nombres', 'LIKE', '%' . $buscarpor . '%')
                        ->orWhere('apellidos', 'LIKE', '%' . $buscarpor . '%')
                        ->paginate(5);

        return view('mantenedor.gerente.trabajador.index', compact('trabajadores', 'buscarpor'));
    }

    public function create()
    {
        return view('mantenedor.gerente.trabajador.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres'      => 'required|max:80',
            'apellidos'    => 'required|max:80',
            'edad'         => 'required|numeric|min:18',
            'email'        => 'required|email|max:100',
            'sexo'         => 'required',
            'estado_civil' => 'required',
        ]);

        $trabajador = new Trabajador();
        $trabajador->nombres = $request->nombres;
        $trabajador->apellidos = $request->apellidos;
        $trabajador->edad = $request->edad;
        $trabajador->email = $request->email;
        $trabajador->sexo = $request->sexo;
        $trabajador->estado_civil = $request->estado_civil;

        $trabajador->save();

        return redirect()->route('gerente.trabajador.index')->with('datos', 'Trabajador registrado exitosamente');
    }

    public function edit($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('mantenedor.gerente.trabajador.edit', compact('trabajador'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres'      => 'required|max:80',
            'apellidos'    => 'required|max:80',
            'edad'         => 'required|numeric|min:18',
            'email'        => 'required|email|max:100',
            'sexo'         => 'required',
            'estado_civil' => 'required',
        ]);

        $trabajador = Trabajador::findOrFail($id);
        $trabajador->nombres = $request->nombres;
        $trabajador->apellidos = $request->apellidos;
        $trabajador->edad = $request->edad;
        $trabajador->email = $request->email;
        $trabajador->sexo = $request->sexo;
        $trabajador->estado_civil = $request->estado_civil;

        $trabajador->save();

        return redirect()->route('gerente.trabajador.index')->with('datos', 'Trabajador actualizado exitosamente');
    }

    public function confirmar($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('mantenedor.gerente.trabajador.confirmar', compact('trabajador'));
    }

    public function destroy($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $trabajador->delete();
        return redirect()->route('gerente.trabajador.index')->with('datos', 'Trabajador eliminado correctamente');
    }

    public function reporteSolicitudes(Request $request)
    {
        $buscar = $request->get('buscarpor');

        $solicitudes = SolicitudLimpieza::where('descripcion', 'LIKE', "%$buscar%")
                        ->orWhere('estado', 'LIKE', "%$buscar%")
                        ->orderBy('id_solicitud', 'desc')
                        ->paginate(10);

        $totalSolicitudes = SolicitudLimpieza::count();
        $atendidas = SolicitudLimpieza::where('estado', 'atendida')->count();
        $pendientes = SolicitudLimpieza::where('estado', '!=', 'atendida')->count();

        $porcentajeAtencion = $totalSolicitudes > 0 ? round(($atendidas / $totalSolicitudes) * 100, 1) : 0;

        $prioridadAlta = SolicitudLimpieza::where('prioridad', 'ALTA')->count();
        $prioridadMedia = SolicitudLimpieza::where('prioridad', 'MEDIA')->count();
        $prioridadBaja = SolicitudLimpieza::where('prioridad', 'BAJA')->count();

        $datosGrafico = [$prioridadAlta, $totalSolicitudes - $prioridadAlta];

        return view('mantenedor.gerente.reportes.solicitudes', compact(
            'solicitudes', 'buscar',
            'totalSolicitudes', 'atendidas', 'pendientes', 'porcentajeAtencion',
            'datosGrafico'
        ));
    }

    public function reporteInfracciones(Request $request)
    {
        $buscar = $request->get('buscarpor');

        $infracciones = Infraccion::where('estadoPago', 'LIKE', "%$buscar%")
                        ->orderBy('id_infraccion', 'desc')
                        ->paginate(10);

        $totalMultas = Infraccion::count();
        $dineroRecaudado = Infraccion::where('estadoPago', 'pagado')->sum('montoMulta');
        $dineroPendiente = Infraccion::where('estadoPago', 'pendiente')->sum('montoMulta');

        $cantPagados = Infraccion::where('estadoPago', 'pagado')->count();
        $cantPendientes = Infraccion::where('estadoPago', 'pendiente')->count();

        return view('mantenedor.gerente.reportes.infracciones', compact(
            'infracciones', 'buscar',
            'totalMultas', 'dineroRecaudado', 'dineroPendiente',
            'cantPagados', 'cantPendientes'
        ));
    }
}
