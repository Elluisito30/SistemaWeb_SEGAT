<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Infraccion;
use App\Models\DetalleInfraccion;
use App\Models\Contribuyente;
use Illuminate\Support\Facades\Auth;

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
        
        // Buscar el contribuyente asociado al usuario (por email)
        $contribuyente = Contribuyente::with('domicilio.distrito')
            ->where('email', $user->email)
            ->first();
        
        // Si no existe el contribuyente, mostrar mensaje
        if (!$contribuyente) {
            return view('mantenedor.ciudadano.consultar_pagos_multas.index', [
                'infracciones' => collect(),
                'mensaje' => 'No se encontró información de contribuyente asociada a su cuenta.'
            ]);
        }
        
        // Obtener todas las infracciones del contribuyente
        // Solo mostramos las que tienen monto (ya validadas por trabajador)
        $infracciones = DetalleInfraccion::with([
            'infraccion',
            'tipo',
            'registroInfraccion.trabajador'
        ])
        ->where('id_contribuyente', $contribuyente->id_contribuyente)
        ->whereHas('infraccion', function($query) {
            // Solo infracciones con monto asignado (validadas)
            $query->whereNotNull('montoMulta');
        })
        ->orderBy('fechaHora', 'desc')
        ->get();
        
        return view('mantenedor.ciudadano.consultar_pagos_multas.index', [
            'infracciones' => $infracciones,
            'contribuyente' => $contribuyente
        ]);
    }
}
