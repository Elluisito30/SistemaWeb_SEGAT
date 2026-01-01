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
        // 1. KPIs para las tarjetas superiores
        $total    = DB::table('solicitud')->count();
        $alta     = DB::table('solicitud')->where('prioridad', 'ALTA')->count();
        $media    = DB::table('solicitud')->where('prioridad', 'MEDIA')->count();
        $baja     = DB::table('solicitud')->where('prioridad', 'BAJA')->count();

        // 2. Consulta principal (igual que antes)
        $solicitudes = DB::table('solicitud')
            ->join('servicio', 'solicitud.id_servicio', '=', 'servicio.id_servicio')
            ->select('solicitud.*', 'servicio.descripcionServicio')
            ->orderBy('fechaTentativaEjecucion', 'desc')
            ->paginate(10);

        return view('mantenedor.gerente.solicitudes.index', compact('solicitudes', 'total', 'alta', 'media', 'baja'));
    }

    public function reporteInfracciones()
    {
        // 1. KPIs Financieros (Suma de montos)
        $recaudado = DB::table('infraccion')->where('estadoPago', 'Pagado')->sum('montoMulta');
        $pendiente = DB::table('infraccion')->where('estadoPago', '!=', 'Pagado')->sum('montoMulta');

        // 2. Datos para Gráfico: "Top 3 infracciones más comunes"
        // (Asumiendo que 'tipoInfraccion' es un número, lo unimos con su descripción)
        $topInfracciones = DB::table('detalleinfraccion')
            ->join('tipoinfraccion', 'detalleinfraccion.tipoInfraccion', '=', 'tipoinfraccion.tipoInfraccion')
            ->select('tipoinfraccion.descripcion', DB::raw('count(*) as total'))
            ->groupBy('tipoinfraccion.descripcion')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        // Preparamos arrays para el gráfico
        $labelsInf = [];
        $dataInf = [];
        foreach($topInfracciones as $item){
            $labelsInf[] = Str::limit($item->descripcion, 20); // Cortamos nombres largos
            $dataInf[] = $item->total;
        }

        // 3. Consulta principal
        $infracciones = DB::table('infraccion')
            ->join('detalleinfraccion', 'infraccion.id_detalleInfraccion', '=', 'detalleinfraccion.id_detalleInfraccion')
            ->select('infraccion.*', 'detalleinfraccion.lugarOcurrencia', 'detalleinfraccion.fechaHora')
            ->orderBy('fechaLimitePago', 'desc')
            ->paginate(10);

        return view('mantenedor.gerente.infracciones.index', compact('infracciones', 'recaudado', 'pendiente', 'labelsInf', 'dataInf'));
    }
}
