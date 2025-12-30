<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudLimpieza;
use App\Models\DetalleSolicitud;
use App\Models\AreaVerde;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class SolicitudLimpiezaController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        
        // Obtener contribuyente del usuario logueado
        $contribuyente = Auth::user()->contribuyente;
        
        if (!$contribuyente) {
            return view('mantenedor.ciudadano.solicitud_limpieza.index', [
                'solicitud' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, self::PAGINATION),
                'buscarpor' => $buscarpor,
                'totalSolicitudes' => 0,
                'totalAlta' => 0,
                'totalMedia' => 0,
                'totalBaja' => 0,
                'mensaje' => 'No se encontró información de contribuyente asociada.'
            ]);
        }
        
        $solicitud = SolicitudLimpieza::with([
                'detalleSolicitud.areaVerde',
                'servicio'
            ])
            ->whereHas('detalleSolicitud', function ($query) use ($contribuyente) {
                // Filtrar por contribuyente del usuario logueado
                $query->where('id_contribuyente', $contribuyente->id_contribuyente);
            })
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->whereHas('detalleSolicitud.areaVerde', function ($q) use ($buscarpor) {
                    $q->where('nombre', 'like', '%' . $buscarpor . '%');
                });
            })
            ->orderBy('id_solicitud', 'desc')
            ->paginate(self::PAGINATION);

        // Contadores totales del contribuyente
        $totalSolicitudes = SolicitudLimpieza::whereHas('detalleSolicitud', function ($query) use ($contribuyente) {
            $query->where('id_contribuyente', $contribuyente->id_contribuyente);
        })->count();

        $totalAlta = SolicitudLimpieza::whereHas('detalleSolicitud', function ($query) use ($contribuyente) {
            $query->where('id_contribuyente', $contribuyente->id_contribuyente);
        })->where('prioridad', 'ALTA')->count();

        $totalMedia = SolicitudLimpieza::whereHas('detalleSolicitud', function ($query) use ($contribuyente) {
            $query->where('id_contribuyente', $contribuyente->id_contribuyente);
        })->where('prioridad', 'MEDIA')->count();

        $totalBaja = SolicitudLimpieza::whereHas('detalleSolicitud', function ($query) use ($contribuyente) {
            $query->where('id_contribuyente', $contribuyente->id_contribuyente);
        })->where('prioridad', 'BAJA')->count();

        return view('mantenedor.ciudadano.solicitud_limpieza.index', compact(
            'solicitud', 
            'buscarpor',
            'totalSolicitudes',
            'totalAlta',
            'totalMedia',
            'totalBaja'
        ));
    }

    public function create()
    {
        $areas = AreaVerde::all();
        $servicios = Servicio::all();
        return view('mantenedor.ciudadano.solicitud_limpieza.create', compact('areas', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_servicio'               => 'required|exists:servicio,id_servicio',
            'id_area'                   => 'required|exists:areaverde,id_area',
            'descripcion'               => 'required|max:40',
            'prioridad'                 => 'required|in:ALTA,MEDIA,BAJA',
            'fechaTentativaEjecucion'   => 'required|date'
        ], [
            'id_servicio.required'              => 'Seleccione un servicio.',
            'id_servicio.exists'                => 'El servicio seleccionado no existe.',
            'id_area.required'                  => 'Seleccione una zona.',
            'id_area.exists'                    => 'La zona seleccionada no existe.',
            'descripcion.required'              => 'Ingrese la descripción.',
            'descripcion.max'                   => 'Máximo 40 caracteres para la descripción.',
            'prioridad.required'                => 'Seleccione la prioridad.',
            'prioridad.in'                      => 'Valor de prioridad no válido.',
            'fechaTentativaEjecucion.required'  => 'Ingrese la fecha tentativa.',
            'fechaTentativaEjecucion.date'      => 'Formato de fecha no válido.'
        ]);

        // Obtener contribuyente del usuario logueado
        $contribuyente = Auth::user()->contribuyente;
        
        if (!$contribuyente) {
            return redirect()->back()->with('error', 'Usuario sin contribuyente asociado. Contacte al administrador.');
        }

        // Crear detalle de solicitud primero
        $detalleSolicitud = new DetalleSolicitud();
        $detalleSolicitud->id_contribuyente = $contribuyente->id_contribuyente;
        $detalleSolicitud->id_area = $request->id_area;
        $detalleSolicitud->save();

        // Buscar el primer ID disponible
        $ultimoId = SolicitudLimpieza::max('id_solicitud') ?? 0;
        $primerIdDisponible = 1;
        
        for ($i = 1; $i <= $ultimoId + 1; $i++) {
            if (!SolicitudLimpieza::where('id_solicitud', $i)->exists()) {
                $primerIdDisponible = $i;
                break;
            }
        }

        // Crear solicitud con ID manual
        $solicitud = new SolicitudLimpieza();
        $solicitud->id_solicitud = $primerIdDisponible; 
        $solicitud->id_detalleSolicitud = $detalleSolicitud->id_detalleSolicitud;
        $solicitud->id_servicio = $request->id_servicio;
        $solicitud->prioridad = $request->prioridad;
        $solicitud->descripcion = $request->descripcion;
        $solicitud->fechaTentativaEjecucion = $request->fechaTentativaEjecucion;
        $solicitud->documentoAdjunto = $request->documentoAdjunto ?? '';
        $solicitud->estado = 'registrada';
        $solicitud->save();

        return redirect()->route('ciudadano.solicitud.index')->with('datos', 'Registro nuevo guardado.');
    }

    public function edit($id)
    {
        $solicitud = SolicitudLimpieza::findOrFail($id);
        $areas = AreaVerde::all();
        $servicios = Servicio::all();
        return view('mantenedor.ciudadano.solicitud_limpieza.edit', compact('solicitud', 'areas', 'servicios'));
    }

    public function update(Request $request, $id)
    {
        $solicitud = SolicitudLimpieza::findOrFail($id);

        $request->validate([
            'id_servicio'               => 'required|exists:servicio,id_servicio',
            'id_area'                   => 'required|exists:areaverde,id_area',
            'descripcion'               => 'required|max:40',
            'prioridad'                 => 'required|in:ALTA,MEDIA,BAJA',
            'fechaTentativaEjecucion'   => 'required|date'
        ], [
            'id_servicio.required'              => 'Seleccione un servicio.',
            'id_servicio.exists'                => 'El servicio seleccionado no existe.',
            'id_area.required'                  => 'Seleccione una zona.',
            'id_area.exists'                    => 'La zona seleccionada no existe.',
            'descripcion.required'              => 'Ingrese la descripción.',
            'descripcion.max'                   => 'Máximo 40 caracteres para la descripción.',
            'prioridad.required'                => 'Seleccione la prioridad.',
            'prioridad.in'                      => 'Valor de prioridad no válido.',
            'fechaTentativaEjecucion.required'  => 'Ingrese la fecha tentativa.',
            'fechaTentativaEjecucion.date'      => 'Formato de fecha no válido.'
        ]);

        // Actualizar detalle de solicitud
        $detalleSolicitud = DetalleSolicitud::findOrFail($solicitud->id_detalleSolicitud);
        $detalleSolicitud->id_area = $request->id_area;
        $detalleSolicitud->save();

        // Actualizar solicitud
        $solicitud->id_servicio = $request->id_servicio;
        $solicitud->prioridad = $request->prioridad;
        $solicitud->descripcion = $request->descripcion;
        $solicitud->fechaTentativaEjecucion = $request->fechaTentativaEjecucion;
        $solicitud->save();

        return redirect()->route('ciudadano.solicitud.index')->with('datos', 'Registro actualizado.');
    }

    public function confirmar($id)
    {
        $solicitud = SolicitudLimpieza::findOrFail($id);
        return view('mantenedor.ciudadano.solicitud_limpieza.confirmar', compact('solicitud'));
    }

    public function destroy($id)
    {
        $solicitud = SolicitudLimpieza::findOrFail($id);
        $solicitud->delete();

        return redirect()->route('ciudadano.solicitud.index')->with('datos', 'Registro eliminado.');
    }
}