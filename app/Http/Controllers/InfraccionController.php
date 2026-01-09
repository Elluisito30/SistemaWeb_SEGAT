<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribuyente;
use App\Models\DetalleInfraccion;
use App\Models\Infraccion;
use App\Models\RegistroInfraccion;
use App\Models\TipoInfraccion;
use App\Models\TipoDocumento;
use App\Models\User;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InfraccionController extends Controller
{
    /**
     * Mostrar formulario para reportar infracción
     */
    public function create()
    {
        $tiposInfraccion = TipoInfraccion::all();
        $tiposDocumento = TipoDocumento::all();
        
        return view('mantenedor.ciudadano.registrar_infraccion.create', [
            'tiposInfraccion' => $tiposInfraccion,
            'tiposDocumento' => $tiposDocumento
        ]);
    }
    
    /**
     * Guardar la infracción reportada
     */
    public function store(Request $request)
    {
        $request->validate([
            'email_infractor' => 'required|email|max:100',
            'numDocumento_infractor' => 'required|max:20',
            'nombres_infractor' => 'nullable|max:80',
            'apellidos_infractor' => 'nullable|max:80',
            'telefono_infractor' => 'nullable|max:20',
            'tipoInfraccion' => 'required|exists:tipoinfraccion,tipoInfraccion',
            'lugarOcurrencia' => 'required|max:50',
            'descripcion' => 'nullable|max:500',
            'documentoAdjunto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        try {
            DB::beginTransaction();

            // 1. Buscar o crear el infractor en la tabla contribuyente
            $infractor = Contribuyente::where('numDocumento', $request->numDocumento_infractor)->first();
            
            if (!$infractor) {
                $infractor = Contribuyente::create([
                    'numDocumento' => $request->numDocumento_infractor,
                    'email' => $request->email_infractor,
                    'telefono' => $request->telefono_infractor,
                    'tipoContribuyente' => 'N',
                    'id_tipoDocumento' => 1,
                    'genero' => null,
                    'celula' => null,
                    'id_domicilio' => null,
                    'user_id' => null
                ]);
            }

            // 2. Subir archivo si existe
            $nombreArchivo = null;
            if ($request->hasFile('documentoAdjunto')) {
                $archivo = $request->file('documentoAdjunto');
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
                $archivo->move(public_path('storage/infracciones'), $nombreArchivo);
            }

            // 3. Crear registro en detalleinfracion
            $detalleInfraccion = DetalleInfraccion::create([
                'id_contribuyente' => $infractor->id_contribuyente,
                'tipoInfraccion' => $request->tipoInfraccion,
                'lugarOcurrencia' => $request->lugarOcurrencia,
                'fechaHora' => now()
            ]);

            // 4. Crear registro en infraccion
            $infraccion = Infraccion::create([
                'id_detalleInfraccion' => $detalleInfraccion->id_detalleInfraccion,
                'montoMulta' => 0.00,
                'fechaLimitePago' => now()->addDays(30),
                'estadoPago' => 'Pendiente',
                'documentoAdjunto' => $nombreArchivo
            ]);

            // 5. NOTIFICAR AL CIUDADANO (quien reportó)
            Notificacion::create([
                'user_id' => Auth::id(),
                'tipo' => 'infraccion',
                'titulo' => 'Infracción registrada',
                'mensaje' => 'Tu reporte de infracción ha sido registrado exitosamente. Será revisado por un trabajador.',
                'url' => route('ciudadano.infracciones.index')
            ]);

            // 6. NOTIFICAR A TODOS LOS TRABAJADORES
            $trabajadores = User::where('role', 'trabajador')->get();
            
            foreach ($trabajadores as $trabajador) {
                Notificacion::create([
                    'user_id' => $trabajador->id,
                    'tipo' => 'infraccion',
                    'titulo' => 'Nueva infracción reportada',
                    'mensaje' => 'Se ha reportado una infracción por "' . $request->tipoInfraccion . '" en ' . $request->lugarOcurrencia,
                    'url' => route('trabajador.infracciones.index')
                ]);
            }

            DB::commit();

            return redirect()
                ->route('ciudadano.infracciones.create')
                ->with('success', 'Infracción reportada exitosamente. Será validada por un trabajador.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al registrar la infracción: ' . $e->getMessage());
        }
    }
}