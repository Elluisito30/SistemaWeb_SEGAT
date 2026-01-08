<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    // ============================================
    // MÉTODOS PARA CIUDADANOS
    // ============================================
    
    public function indexCiudadano(Request $request) 
    {
        $query = Notificacion::where('user_id', Auth::id());

        // Filtro por rango de fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $notificaciones = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('mantenedor.ciudadano.notificaciones.index', compact('notificaciones'));
    }

    public function noLeidasCiudadano()
    {
        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->noLeidas()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'count' => $notificaciones->count(),
            'notificaciones' => $notificaciones
        ]);
    }

    // ============================================
    // MÉTODOS PARA TRABAJADORES
    // ============================================
    
    public function indexTrabajador(Request $request) 
    {
        $query = Notificacion::where('user_id', Auth::id());

        // Filtro por rango de fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $notificaciones = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('mantenedor.trabajador.notificaciones.index', compact('notificaciones'));
    }

    public function noLeidasTrabajador()
    {
        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->noLeidas()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'count' => $notificaciones->count(),
            'notificaciones' => $notificaciones
        ]);
    }

    // ============================================
    // MÉTODOS COMPARTIDOS
    // ============================================
    
    public function marcarLeida($id)
    {
        $notificacion = Notificacion::where('id_notificacion', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notificacion->marcarComoLeida();

        return response()->json(['success' => true]);
    }

    public function marcarTodasLeidas()
    {
        Notificacion::where('user_id', Auth::id())
            ->where('leida', 0)
            ->update(['leida' => 1]);

        return response()->json(['success' => true]);
    }
}