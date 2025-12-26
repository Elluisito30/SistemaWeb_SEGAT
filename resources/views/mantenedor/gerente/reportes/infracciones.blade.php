@extends('layout.plantillaGerente')
@section('titulo','Reporte de Infracciones')
@section('contenido')

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-4 col-6 mt-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalMultas }}</h3>
                    <p>Total Infracciones</p>
                </div>
                <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6 mt-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>S/. {{ number_format($dineroRecaudado, 2) }}</h3>
                    <p>Dinero Recaudado</p>
                </div>
                <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6 mt-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>S/. {{ number_format($dineroPendiente, 2) }}</h3>
                    <p>Por Cobrar (Pendiente)</p>
                </div>
                <div class="icon"><i class="fas fa-comment-dollar"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">Listado de Multas</h3>
                    <div class="card-tools">
                        <form class="form-inline" method="GET" action="{{ route('gerente.reportes.infracciones') }}">
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
                                <th>Monto</th>
                                <th>Vencimiento</th>
                                <th>Estado Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($infracciones as $infraccion)
                            <tr>
                                <td>{{ $infraccion->id_infraccion }}</td>
                                <td class="text-bold">S/. {{ $infraccion->montoMulta }}</td>
                                <td>{{ substr($infraccion->fechaLimitePago, 0, 10) }}</td>
                                <td>
                                    @php $est = mb_strtolower($infraccion->estadoPago, 'UTF-8'); @endphp
                                    @if($est == 'pagado')
                                        <span class="badge badge-success">PAGADO</span>
                                    @else
                                        <span class="badge badge-danger">PENDIENTE</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center">No se encontraron registros</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $infracciones->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Estado de Cobranza</h3>
                </div>
                <div class="card-body">
                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <div class="card-footer text-center">
                    <p>Total Recaudación vs Deuda</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: ['Pagado', 'Pendiente'],
            datasets: [{
                data: [{{ $cantPagados }}, {{ $cantPendientes }}],
                backgroundColor : ['#28a745', '#dc3545'],
            }]
        }
        var donutOptions = { maintainAspectRatio : false, responsive : true }
        new Chart(donutChartCanvas, { type: 'doughnut', data: donutData, options: donutOptions })
    });
</script>
@endsection
