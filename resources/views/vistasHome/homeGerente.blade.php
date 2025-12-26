@extends('layout.plantillaGerente')

@section('titulo', 'Dashboard Gerencia')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Panel de Supervisión</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalSolicitudes }}</h3>
                        <p>Solicitudes</p>
                    </div>
                    <div class="icon"><i class="fas fa-broom"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalInfracciones }}</h3>
                        <p>Infracciones</p>
                    </div>
                    <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalTrabajadores }}</h3>
                        <p>Trabajadores</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <a href="{{ route('gerente.trabajador.index') }}" class="small-box-footer">Gestionar <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Estado de Solicitudes</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>

                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Últimas Infracciones</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Monto</th>
                                    <th>Estado Pago</th>
                                    <th>Vence</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimasInfracciones as $infraccion)
                                <tr>
                                    <td>{{ $infraccion->id_infraccion }}</td>
                                    <td>S/. {{ $infraccion->montoMulta }}</td> <td>
                                        <span class="badge badge-{{ $infraccion->estadoPago == 'pagado' ? 'success' : 'danger' }}">
                                            {{ ucfirst($infraccion->estadoPago) }} </span>
                                    </td>
                                    <td>{{ substr($infraccion->fechaLimitePago, 0, 10) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center">Sin registros</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Solicitudes Recientes</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th>Descripción</th> <th>Fecha Tentativa</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($ultimasSolicitudes as $solicitud)
                                <tr>
                                    <td>{{ Str::limit($solicitud->descripcion, 20) }}</td>

                                    <td>{{ substr($solicitud->fechaTentativaEjecucion, 0, 10) }}</td>

                                    <td>
                                        <span class="badge badge-{{ $solicitud->prioridad == 'ALTA' ? 'danger' : 'info' }}">
                                            {{ $solicitud->prioridad }}
                                        </span>
                                    </td>
                                    <td>
                                        @php $est = strtolower($solicitud->estado); @endphp
                                        @if($est == 'registrada') <span class="badge badge-secondary">Registrada</span>
                                        @elseif($est == 'en atención') <span class="badge badge-warning">En Proceso</span>
                                        @elseif($est == 'atendida') <span class="badge badge-success">Atendida</span>
                                        @else <span class="badge badge-danger">{{ $solicitud->estado }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center">No hay datos</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: @json($labelsGrafico),
            datasets: [{
                data: @json($dataSolicitudes),
                backgroundColor : ['#6c757d', '#ffc107', '#28a745', '#dc3545'],
            }]
        }
        var donutOptions = { maintainAspectRatio : false, responsive : true }
        new Chart(donutChartCanvas, { type: 'doughnut', data: donutData, options: donutOptions })
    });
</script>
@endsection
