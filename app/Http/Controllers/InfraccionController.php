<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Infraccion;
use App\Models\DetalleInfraccion;
use App\Models\Contribuyente;
use App\Models\TipoInfraccion;
use App\Models\TipoDocumento;
use App\Models\Domicilio;
use App\Models\Distrito;
use Illuminate\Support\Facades\Storage;

class InfraccionController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $infracciones = Infraccion::with([
            'detalleInfraccion.contribuyente.tipoDocumento',
            'detalleInfraccion.contribuyente.domicilio.distrito',
            'detalleInfraccion.tipoInfraccion'
        ])
        ->whereHas('detalleInfraccion.contribuyente', function($query) use ($buscarpor) {
            $query->where('numDocumento', 'like', '%'.$buscarpor.'%');
        })
        ->orWhereHas('detalleInfraccion', function($query) use ($buscarpor) {
            $query->where('lugarOcurrencia', 'like', '%'.$buscarpor.'%');
        })
        ->paginate($this::PAGINATION);

        return view('modulo2.infraccion.index', compact('infracciones', 'buscarpor'));
    }

    public function create()
    {
        // Opción 1: Seleccionar contribuyente existente
        $contribuyentes = Contribuyente::with('tipoDocumento', 'domicilio')->get();
        
        // Opción 2: Datos para crear contribuyente nuevo
        $tiposDocumento = TipoDocumento::all();
        $distritos = Distrito::all();
        
        // Tipos de infracción disponibles
        $tiposInfraccion = TipoInfraccion::all();

        return view('modulo2.infraccion.create', compact(
            'contribuyentes',
            'tiposDocumento',
            'distritos',
            'tiposInfraccion'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Datos del contribuyente (si es nuevo)
            'es_nuevo_contribuyente' => 'sometimes|boolean',
            'contribuyente_id' => 'required_if:es_nuevo_contribuyente,false|nullable|exists:contribuyente,id_contribuyente',
            
            // Datos para contribuyente nuevo
            'id_tipoDocumento' => 'required_if:es_nuevo_contribuyente,true|nullable|exists:tipo_documento,id_TipoDocumento',
            'numDocumento' => 'required_if:es_nuevo_contribuyente,true|nullable|max:20',
            'genero' => 'required_if:es_nuevo_contribuyente,true|nullable|in:Masculino,Femenino',
            'telefono' => 'nullable|max:7',
            'celula' => 'nullable|max:9',
            'email' => 'nullable|email|max:100',
            'tipoContribuyente' => 'required_if:es_nuevo_contribuyente,true|nullable|in:N,J',
            
            // Domicilio (si es nuevo contribuyente)
            'direccionDomi' => 'required_if:es_nuevo_contribuyente,true|nullable|max:30',
            'tipoDomi' => 'required_if:es_nuevo_contribuyente,true|nullable|max:1',
            'id_distrito' => 'required_if:es_nuevo_contribuyente,true|nullable|exists:distrito,id_distrito',
            
            // Datos del detalle de infracción
            'lugarOcurrencia' => 'required|max:50',
            'fechaHora' => 'required|date',
            'tipoInfraccion' => 'required|exists:tipoinfraccion,tipoInfraccion',
            
            // Datos de la infracción
            'montoMulta' => 'required|numeric|min:0|max:99999999.99',
            'fechaLimitePago' => 'required|date|after:fechaHora',
            'estadoPago' => 'required|in:Pendiente,Pagado,Vencido',
            'documentoAdjunto' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ],
        [
            // Mensajes de validación para contribuyente
            'contribuyente_id.required_if' => 'Debe seleccionar un contribuyente existente',
            'contribuyente_id.exists' => 'El contribuyente seleccionado no existe',
            
            'id_tipoDocumento.required_if' => 'Seleccione el tipo de documento',
            'numDocumento.required_if' => 'Ingrese el número de documento',
            'genero.required_if' => 'Seleccione el género',
            'genero.in' => 'El género debe ser Masculino o Femenino',
            'tipoContribuyente.required_if' => 'Seleccione el tipo de contribuyente',
            'tipoContribuyente.in' => 'El tipo debe ser N (Natural) o J (Jurídico)',
            
            // Mensajes de validación para domicilio
            'direccionDomi.required_if' => 'Ingrese la dirección del domicilio',
            'id_distrito.required_if' => 'Seleccione el distrito',
            
            // Mensajes de validación para detalle de infracción
            'lugarOcurrencia.required' => 'Ingrese el lugar de la infracción',
            'lugarOcurrencia.max' => 'Máximo 50 caracteres para el lugar',
            'fechaHora.required' => 'Ingrese la fecha y hora de la infracción',
            'fechaHora.date' => 'Formato de fecha inválido',
            'tipoInfraccion.required' => 'Seleccione el tipo de infracción',
            'tipoInfraccion.exists' => 'El tipo de infracción no existe',
            
            // Mensajes de validación para infracción
            'montoMulta.required' => 'Ingrese el monto de la multa',
            'montoMulta.numeric' => 'El monto debe ser un número',
            'montoMulta.min' => 'El monto debe ser mayor a 0',
            'montoMulta.max' => 'El monto excede el límite permitido',
            'fechaLimitePago.required' => 'Ingrese la fecha límite de pago',
            'fechaLimitePago.after' => 'La fecha límite debe ser posterior a la fecha de infracción',
            'estadoPago.required' => 'Seleccione el estado de pago',
            'estadoPago.in' => 'Estado de pago inválido',
            'documentoAdjunto.mimes' => 'El documento debe ser PDF, JPG o PNG',
            'documentoAdjunto.max' => 'El archivo no debe superar 2MB',
        ]);

        // Paso 1: Gestionar el contribuyente
        if ($request->es_nuevo_contribuyente) {
            // Crear domicilio primero
            $domicilio = new Domicilio();
            $domicilio->direccionDomi = $request->direccionDomi;
            $domicilio->tipoDomi = $request->tipoDomi;
            $domicilio->id_distrito = $request->id_distrito;
            $domicilio->save();

            // Crear contribuyente nuevo
            $contribuyente = new Contribuyente();
            $contribuyente->id_tipoDocumento = $request->id_tipoDocumento;
            $contribuyente->numDocumento = $request->numDocumento;
            $contribuyente->genero = $request->genero;
            $contribuyente->telefono = $request->telefono;
            $contribuyente->celula = $request->celula;
            $contribuyente->email = $request->email;
            $contribuyente->tipoContribuyente = $request->tipoContribuyente;
            $contribuyente->id_domicilio = $domicilio->id_domicilio;
            $contribuyente->save();

            $contribuyenteId = $contribuyente->id_contribuyente;
        } else {
            // Usar contribuyente existente
            $contribuyenteId = $request->contribuyente_id;
        }

        // Verificar si es reincidente
        $contribuyente = Contribuyente::find($contribuyenteId);
        $esReincidente = $contribuyente->esReincidente();

        // Paso 2: Crear el detalle de infracción
        $detalle = new DetalleInfraccion();
        $detalle->id_contribuyente = $contribuyenteId;
        $detalle->lugarOcurrencia = $request->lugarOcurrencia;
        $detalle->fechaHora = $request->fechaHora;
        $detalle->tipoInfraccion = $request->tipoInfraccion;
        $detalle->save();

        // Paso 3: Crear la infracción principal
        $infraccion = new Infraccion();
        $infraccion->id_detalleInfraccion = $detalle->id_detalleInfraccion;
        
        // Aplicar recargo si es reincidente
        $montoFinal = $request->montoMulta;
        if ($esReincidente) {
            $montoFinal = $montoFinal * 1.5; // 50% de recargo
        }
        
        $infraccion->montoMulta = $montoFinal;
        $infraccion->fechaLimitePago = $request->fechaLimitePago;
        $infraccion->estadoPago = $request->estadoPago;

        // Guardar documento adjunto si existe
        if ($request->hasFile('documentoAdjunto')) {
            $path = $request->file('documentoAdjunto')->store('infracciones', 'public');
            $infraccion->documentoAdjunto = $path;
        }

        $infraccion->save();

        $mensaje = 'Infracción registrada exitosamente';
        if ($esReincidente) {
            $mensaje .= ' - ¡REINCIDENTE! Se aplicó recargo del 50%';
        }

        return redirect()->route('infraccion.index')->with('datos', $mensaje);
    }

    public function edit(string $id)
    {
        $infraccion = Infraccion::with([
            'detalleInfraccion.contribuyente.tipoDocumento',
            'detalleInfraccion.contribuyente.domicilio.distrito',
            'detalleInfraccion.tipoInfraccion'
        ])->findOrFail($id);

        $tiposInfraccion = TipoInfraccion::all();
        $distritos = Distrito::all();

        return view('modulo2.infraccion.edit', compact(
            'infraccion',
            'tiposInfraccion',
            'distritos'
        ));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            // Solo permitir editar ciertos campos de la infracción
            'montoMulta' => 'required|numeric|min:0|max:99999999.99',
            'fechaLimitePago' => 'required|date',
            'estadoPago' => 'required|in:Pendiente,Pagado,Vencido',
            'documentoAdjunto' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            
            // Datos del detalle (editables)
            'lugarOcurrencia' => 'required|max:50',
            'tipoInfraccion' => 'required|exists:tipoinfracccion,tipoInfraccion',
        ],
        [
            'montoMulta.required' => 'Ingrese el monto de la multa',
            'montoMulta.numeric' => 'El monto debe ser un número',
            'fechaLimitePago.required' => 'Ingrese la fecha límite de pago',
            'estadoPago.required' => 'Seleccione el estado de pago',
            'lugarOcurrencia.required' => 'Ingrese el lugar de la infracción',
            'tipoInfraccion.required' => 'Seleccione el tipo de infracción',
        ]);

        $infraccion = Infraccion::findOrFail($id);
        
        // Actualizar infracción
        $infraccion->montoMulta = $request->montoMulta;
        $infraccion->fechaLimitePago = $request->fechaLimitePago;
        $infraccion->estadoPago = $request->estadoPago;

        // Actualizar documento si se subió uno nuevo
        if ($request->hasFile('documentoAdjunto')) {
            // Eliminar documento anterior si existe
            if ($infraccion->documentoAdjunto && Storage::disk('public')->exists($infraccion->documentoAdjunto)) {
                Storage::disk('public')->delete($infraccion->documentoAdjunto);
            }
            
            $path = $request->file('documentoAdjunto')->store('infracciones', 'public');
            $infraccion->documentoAdjunto = $path;
        }

        $infraccion->save();

        // Actualizar detalle de infracción
        $detalle = $infraccion->detalleInfraccion;
        $detalle->lugarOcurrencia = $request->lugarOcurrencia;
        $detalle->tipoInfraccion = $request->tipoInfraccion;
        $detalle->save();

        return redirect()->route('infraccion.index')->with('datos', 'Infracción actualizada correctamente');
    }

    public function confirmar($id)
    {
        $infraccion = Infraccion::with([
            'detalleInfraccion.contribuyente.tipoDocumento',
            'detalleInfraccion.contribuyente.domicilio.distrito',
            'detalleInfraccion.tipoInfraccion'
        ])->findOrFail($id);

        return view('modulo2.infraccion.confirmar', compact('infraccion'));
    }

    public function destroy(string $id)
    {
        $infraccion = Infraccion::findOrFail($id);
        
        // Eliminar documento adjunto si existe
        if ($infraccion->documentoAdjunto && Storage::disk('public')->exists($infraccion->documentoAdjunto)) {
            Storage::disk('public')->delete($infraccion->documentoAdjunto);
        }

        // Obtener el detalle antes de eliminar
        $detalleId = $infraccion->id_detalleInfraccion;
        
        // Eliminar infracción
        $infraccion->delete();
        
        // Eliminar detalle (si no tiene otras relaciones)
        $detalle = DetalleInfraccion::find($detalleId);
        if ($detalle && !$detalle->registrosInfraccion()->exists() && !$detalle->deudaFraccionar()->exists()) {
            $detalle->delete();
        }

        return redirect()->route('infraccion.index')->with('datos', 'Infracción eliminada correctamente');
    }

    // Método adicional: Ver detalles completos de una infracción
    public function show($id)
    {
        $infraccion = Infraccion::with([
            'detalleInfraccion.contribuyente.tipoDocumento',
            'detalleInfraccion.contribuyente.domicilio.distrito',
            'detalleInfraccion.tipoInfraccion',
            'registrosInfraccion.trabajador'
        ])->findOrFail($id);

        // Obtener historial del contribuyente
        $historialInfracciones = $infraccion->detalleInfraccion->contribuyente
            ->infracciones()
            ->with('detalleInfraccion.tipoInfraccion')
            ->orderBy('id_infraccion', 'desc')
            ->get();

        return view('modulo2.infraccion.show', compact('infraccion', 'historialInfracciones'));
    }

}
