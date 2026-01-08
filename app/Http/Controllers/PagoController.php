<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagoInfraccion;
use App\Models\Infraccion;
use App\Models\DetalleInfraccion;
use App\Models\Contribuyente;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Mostrar todas las multas/infracciones del ciudadano logueado
     * Solo lectura
     */
    public function index()
    {
        // Obtener el usuario logueado
        $user = Auth::user();
        
        // Buscar el contribuyente asociado al usuario (por user_id)
        $contribuyente = Contribuyente::with('domicilio.distrito')
            ->where('user_id', $user->id)
            ->first();
        
        // Si no existe el contribuyente, mostrar mensaje
        if (!$contribuyente) {
            return view('mantenedor.ciudadano.consultar_pagos_multas.index', [
                'infracciones' => collect(),
                'mensaje' => 'No se encontró información de contribuyente asociada a su cuenta.'
            ]);
        }
        
        // Obtener todas las infracciones del contribuyente
        // Mostramos todas: pendientes (monto=0) y validadas (monto>0)
        $infracciones = DetalleInfraccion::with([
            'infraccion',
            'tipo',
            'registroInfraccion.trabajador'
        ])
        ->where('id_contribuyente', $contribuyente->id_contribuyente)
        ->whereHas('infraccion')
        ->orderBy('fechaHora', 'desc')
        ->get();
        
        return view('mantenedor.ciudadano.consultar_pagos_multas.index', [
            'infracciones' => $infracciones,
            'contribuyente' => $contribuyente
        ]);
    }

    /**
     * Mostrar infracciones pendientes de pago del ciudadano (para realizar pagos)
     */
    public function indexPagos()
    {
        $user = Auth::user();
        
        // Buscar el contribuyente asociado al usuario
        $contribuyente = Contribuyente::where('user_id', $user->id)->first();
        
        if (!$contribuyente) {
            return view('mantenedor.ciudadano.pagos.index', [
                'mensaje' => 'No se encontró información de contribuyente asociada a tu cuenta.',
                'infracciones' => collect([])
            ]);
        }

        // Obtener infracciones del contribuyente que están pendientes de pago
        $infracciones = DetalleInfraccion::with(['infraccion', 'tipo', 'contribuyente'])
            ->where('id_contribuyente', $contribuyente->id_contribuyente)
            ->whereHas('infraccion', function($query) {
                $query->where('estadoPago', '!=', 'Pagada')
                      ->where('montoMulta', '>', 0); // Solo las que ya tienen monto asignado
            })
            ->orderBy('fechaHora', 'desc')
            ->get();

        return view('mantenedor.ciudadano.pagos.index', compact('infracciones', 'contribuyente'));
    }

    /**
     * Mostrar formulario de pago para una infracción específica
     */
    public function create($id)
    {
        $user = Auth::user();
        $contribuyente = Contribuyente::where('user_id', $user->id)->first();

        if (!$contribuyente) {
            return redirect()->route('ciudadano.pagos.index')
                ->with('error', 'No se encontró información de contribuyente.');
        }

        // Buscar la infracción y verificar que pertenece al contribuyente
        $infraccion = Infraccion::with('detalleInfraccion.contribuyente', 'detalleInfraccion.tipo')
            ->whereHas('detalleInfraccion', function($query) use ($contribuyente) {
                $query->where('id_contribuyente', $contribuyente->id_contribuyente);
            })
            ->where('id_infraccion', $id)
            ->where('estadoPago', '!=', 'Pagada')
            ->first();

        if (!$infraccion) {
            return redirect()->route('ciudadano.pagos.index')
                ->with('error', 'Infracción no encontrada o ya fue pagada.');
        }

        return view('mantenedor.ciudadano.pagos.create', compact('infraccion', 'contribuyente'));
    }

    /**
     * Procesar el pago de la infracción
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'id_infraccion' => 'required|exists:infraccion,id_infraccion',
            'montoPagado' => 'required|numeric|min:0.01',
            'metodoPago' => 'required|in:Efectivo,Transferencia,Tarjeta,Yape,Plin',
            'numeroOperacion' => 'nullable|max:50',
            'entidadFinanciera' => 'nullable|max:100',
            'fechaPago' => 'required|date',
            'observaciones' => 'nullable|max:500',
            'comprobanteAdjunto' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ], [
            'id_infraccion.required' => 'La infracción es requerida',
            'montoPagado.required' => 'El monto pagado es requerido',
            'montoPagado.numeric' => 'El monto debe ser un número',
            'montoPagado.min' => 'El monto debe ser mayor a 0',
            'metodoPago.required' => 'Debe seleccionar un método de pago',
            'metodoPago.in' => 'Método de pago no válido',
            'fechaPago.required' => 'La fecha de pago es requerida',
            'fechaPago.date' => 'Fecha de pago inválida',
            'comprobanteAdjunto.file' => 'El comprobante debe ser un archivo',
            'comprobanteAdjunto.mimes' => 'El comprobante debe ser PDF, JPG, JPEG o PNG',
            'comprobanteAdjunto.max' => 'El comprobante no debe pesar más de 5MB'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $contribuyente = Contribuyente::where('user_id', $user->id)->first();

            if (!$contribuyente) {
                return redirect()->back()->with('error', 'No se encontró información de contribuyente.');
            }

            // Verificar que la infracción existe y no está pagada
            $infraccion = Infraccion::with('detalleInfraccion.registroInfraccion.trabajador')
                ->where('id_infraccion', $request->id_infraccion)
                ->where('estadoPago', '!=', 'Pagada')
                ->first();

            if (!$infraccion) {
                return redirect()->back()->with('error', 'Infracción no encontrada o ya está pagada.');
            }

            // Subir comprobante si existe
            $nombreComprobante = null;
            if ($request->hasFile('comprobanteAdjunto')) {
                $archivo = $request->file('comprobanteAdjunto');
                $nombreComprobante = time() . '_' . $archivo->getClientOriginalName();
                $archivo->move(public_path('storage/comprobantes'), $nombreComprobante);
            }

            // Crear registro de pago
            PagoInfraccion::create([
                'id_infraccion' => $request->id_infraccion,
                'id_contribuyente' => $contribuyente->id_contribuyente,
                'montoPagado' => $request->montoPagado,
                'fechaPago' => $request->fechaPago,
                'metodoPago' => $request->metodoPago,
                'numeroOperacion' => $request->numeroOperacion,
                'entidadFinanciera' => $request->entidadFinanciera,
                'comprobanteAdjunto' => $nombreComprobante,
                'observaciones' => $request->observaciones,
                'estado' => 'Aprobado', // Aprobado automáticamente
                'fechaRegistro' => now()
            ]);

            // Actualizar estado de la infracción a "Pagada"
            $infraccion->update([
                'estadoPago' => 'Pagada'
            ]);

            // 🔔 NOTIFICAR AL TRABAJADOR QUE VALIDÓ LA INFRACCIÓN
            if ($infraccion->detalleInfraccion->registroInfraccion?->trabajador?->user_id) {
                Notificacion::create([
                    'user_id' => $infraccion->detalleInfraccion->registroInfraccion->trabajador->user_id,
                    'tipo' => 'pago',
                    'titulo' => 'Multa pagada',
                    'mensaje' => 'El ciudadano ' . $contribuyente->email . ' ha pagado la multa por "' . $infraccion->detalleInfraccion->tipo->descripcion . '".',
                    'url' => route('trabajador.infracciones.historial')
                ]);
            }

            DB::commit();

            return redirect()->route('ciudadano.pagos.index')
                ->with('success', 'Pago registrado exitosamente. La multa ha sido marcada como pagada.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar historial de pagos del ciudadano
     */
    public function historial()
    {
        $user = Auth::user();
        $contribuyente = Contribuyente::where('user_id', $user->id)->first();

        if (!$contribuyente) {
            return view('mantenedor.ciudadano.pagos.historial', [
                'mensaje' => 'No se encontró información de contribuyente.',
                'pagos' => collect([])
            ]);
        }

        // Obtener todos los pagos del contribuyente
        $pagos = PagoInfraccion::with(['infraccion.detalleInfraccion.tipo'])
            ->where('id_contribuyente', $contribuyente->id_contribuyente)
            ->orderBy('fechaRegistro', 'desc')
            ->paginate(10);

        return view('mantenedor.ciudadano.pagos.historial', compact('pagos', 'contribuyente'));
    }
}