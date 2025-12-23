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

        $solicitud = SolicitudLimpieza::where('descripcion', 'like', '%' . $buscarpor . '%')
            ->paginate(self::PAGINATION);

        return view('mantenedor.ciudadano.solicitud_limpieza.index', compact('solicitud', 'buscarpor'));
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

        // Crear solicitud
        $solicitud = new SolicitudLimpieza();
        $solicitud->id_detalleSolicitud = $detalleSolicitud->id_detalleSolicitud;
        $solicitud->id_servicio = $request->id_servicio;
        $solicitud->prioridad = $request->prioridad;
        $solicitud->descripcion = $request->descripcion;
        $solicitud->fechaTentativaEjecucion = $request->fechaTentativaEjecucion;
        $solicitud->documentoAdjunto = $request->documentoAdjunto ?? '';
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