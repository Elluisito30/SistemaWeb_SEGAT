<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenteController extends Controller
{
    public function dashboard()
    {
        // 1. Datos Reales (Conteo de la Base de Datos)
        $totalSolicitudes = DB::table('solicitud')->where('estado', '!=', 'atendida')->count(); // Pendientes
        $totalAreas = DB::table('areaverde')->count();
        $totalTrabajadores = DB::table('users')->where('role', 'trabajador')->count();
        $totalInfracciones = DB::table('infraccion')->where('estadoPago', '!=', 'Pagado')->count(); // Activas

        // 2. Datos para el Gráfico (Solicitudes por Estado)
        $datosGrafico = DB::table('solicitud')
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        $labels = [];
        $data = [];
        foreach($datosGrafico as $item) {
            $labels[] = ucfirst($item->estado);
            $data[] = $item->total;
        }

        // Apunta a tu archivo existente en vistasHome
        return view('vistasHome.homeGerente', compact(
            'totalSolicitudes', 'totalAreas', 'totalTrabajadores', 'totalInfracciones',
            'labels', 'data'
        ));
    }

    public function reporteSolicitudes()
    {
        $solicitudes = DB::table('solicitud')
            ->join('servicio', 'solicitud.id_servicio', '=', 'servicio.id_servicio')
            ->select('solicitud.*', 'servicio.descripcionServicio')
            ->orderBy('fechaTentativaEjecucion', 'desc')
            ->paginate(10);

        // Apunta a la carpeta mantenedor/gerente
        return view('mantenedor.gerente.solicitudes.index', compact('solicitudes'));
    }

    public function reporteInfracciones()
    {
        $infracciones = DB::table('infraccion')
            ->join('detalleinfraccion', 'infraccion.id_detalleInfraccion', '=', 'detalleinfraccion.id_detalleInfraccion')
            ->select('infraccion.*', 'detalleinfraccion.lugarOcurrencia', 'detalleinfraccion.fechaHora')
            ->orderBy('fechaLimitePago', 'desc')
            ->paginate(10);

        // Apunta a la carpeta mantenedor/gerente
        return view('mantenedor.gerente.infracciones.index', compact('infracciones'));
    }
}
