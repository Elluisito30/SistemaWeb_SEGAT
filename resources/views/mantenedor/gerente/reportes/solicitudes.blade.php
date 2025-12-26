@extends('layout.plantillaGerente')
@section('titulo','Reporte de Solicitudes')
@section('contenido')

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-4 col-6 mt-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalSolicitudes }}</h3>
                    <p>Total Registrado</p>
                </div>
                <div class="icon"><i class="fas fa-clipboard-list"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6 mt-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $porcentajeAtencion }}<sup style="font-size: 20px">%</sup></h3>
                    <p>Tasa de Atención</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6 mt-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendientes }}</h3>
                    <p>Pendientes de Atención</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Listado Detallado</h3>

                    <div class="card-tools">
                        <form class="form-inline" method="GET" action="{{ route('gerente.reportes.solicitudes') }}">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input name="buscarpor" class="form-control float-right" type="search"
                                       placeholder="Buscar estado..." value="{{ $buscar }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($solicitudes as $solicitud)
                            <tr>
                                <td>{{ $solicitud->id_solicitud }}</td>
                                <td>{{ Str::limit($solicitud->descripcion, 30) }}</td>
                                <td>{{ substr($solicitud->fechaTentativaEjecucion, 0, 10) }}</td>
                                <td>
                                    <span class="badge badge-{{ $solicitud->prioridad == 'ALTA' ? 'danger' : 'secondary' }}">
                                        {{ $solicitud->prioridad }}
                                    </span>
                                </td>
                                <td>
                                    @php $est = mb_strtolower($solicitud->estado, 'UTF-8'); @endphp
                                    @if($est == 'atendida') <span class="badge badge-success">Atendida</span>
                                    @elseif($est == 'registrada') <span class="badge badge-info">Registrada</span>
                                    @else <span class="badge badge-warning">{{ $solicitud->estado }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">No hay datos</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $solicitudes->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Prioridad de Atención</h3>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Alta Prioridad
                                <span class="float-right text-danger">
                                    <i class="fas fa-arrow-up"></i> {{ $datosGrafico[0] }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Normal / Baja
                                <span class="float-right text-secondary">
                                    <i class="fas fa-arrow-down"></i> {{ $datosGrafico[1] }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = {
            labels: ['Alta', 'Normal/Baja'],
            datasets: [{
                data: @json($datosGrafico),
                backgroundColor : ['#dc3545', '#6c757d'],
            }]
        }
        var pieOptions = { maintainAspectRatio : false, responsive : true }
        new Chart(pieChartCanvas, { type: 'pie', data: pieData, options: pieOptions })
    });
</script>
@endsection
