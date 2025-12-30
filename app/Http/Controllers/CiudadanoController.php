<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SolicitudLimpieza;
use App\Models\DetalleInfraccion;
use App\Models\AreaVerde;

class CiudadanoController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $contribuyente = $user->contribuyente ?? null;

        if (!$contribuyente) {
            return view('vistasHome.homeCiudadano', [
                'solicitudes' => 0,
                'enProceso' => 0,
                'infracciones' => 0,
                'areasVerdes' => 0,
                'mensaje_alerta' => 'No tiene perfil de contribuyente asociado. Por favor, complete su registro.'
            ]);
        }

        //  1. Contar solicitudes del ciudadano
        $solicitudes = SolicitudLimpieza::whereHas('detalleSolicitud', function ($query) use ($contribuyente) {
            $query->where('id_contribuyente', $contribuyente->id_contribuyente);
        })->count();

        //  2. Contar solicitudes en proceso ("en_atencion")
        $enProceso = SolicitudLimpieza::whereHas('detalleSolicitud', function ($query) use ($contribuyente) {
            $query->where('id_contribuyente', $contribuyente->id_contribuyente);
        })->where('estado', 'en_atencion')->count();

        //  3. Contar infracciones del ciudadano (como infractor)
        $infracciones = DetalleInfraccion::where('id_contribuyente', $contribuyente->id_contribuyente)->count();

        //  4. Contar áreas verdes en su distrito
        $areasVerdes = 0;
        if ($contribuyente->domicilio && $contribuyente->domicilio->id_distrito) {
            $areasVerdes = AreaVerde::where('id_distrito', $contribuyente->domicilio->id_distrito)->count();
        }

        // Enviar datos a la vista
        return view('vistasHome.homeCiudadano', compact(
            'solicitudes',
            'enProceso',
            'infracciones',
            'areasVerdes'
        ));
    }
}