@extends('layout.plantillaTrabajador')
@section('titulo', 'Historial de Infracciones Validadas')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <!-- Header verde -->
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #2d5f3f;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-history mr-2"></i> HISTORIAL DE INFRACCIONES VALIDADAS
                    </h5>
                </div>

                <div class="card-body p-4">

                    <!-- Buscador y botón Volver a Pendientes -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('trabajador.infracciones.historial') }}">
                                <div class="input-group shadow-sm">
                                    <input type="text" 
                                           name="buscarpor" 
                                           class="form-control border-0" 
                                           placeholder="Buscar por documento o email del infractor..."
                                           value="{{ $buscarpor }}"
                                           style="background-color: #f8f9fa;">
                                    <button class="btn text-white" type="submit" style="background-color: #2d5f3f;">
                                        <i class="fas fa-search mr-2"></i> Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('trabajador.infracciones.index') }}" 
                               class="btn text-white shadow-sm" 
                               style="background-color: #5cb85c;">
                                <i class="fas fa-arrow-left mr-2"></i> Volver a Pendientes
                            </a>
                        </div>
                    </div>

                    <!-- Tabla de historial -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                            <thead style="background-color: #2d5f3f; color: white;">
                                <tr>
                                    <th>Fecha de validación</th>
                                    <th>Infractor</th>
                                    <th>Tipo de infracción</th>
                                    <th>Lugar de la infracción</th>
                                    <th>Monto de multa</th>
                                    <th>Estado del pago</th>
                                    <th>Fecha límite de pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($infracciones->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No has validado infracciones aún</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($infracciones as $item)
                                        <tr class="shadow-sm" style="background-color: white;">
                                            <td>
                                                <strong>{{ \Carbon\Carbon::parse($item->fechaHoraEmision)->format('d/m/Y') }}</strong><br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->fechaHoraEmision)->format('H:i') }}</small>
                                            </td>
                                            <td class="text-start">
                                                <div><strong>{{ $item->detalleInfraccion->contribuyente->numDocumento ?? 'N/A' }}</strong></div>
                                                <small class="text-muted">{{ $item->detalleInfraccion->contribuyente->email ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark px-2 py-1">
                                                    {{ $item->detalleInfraccion->tipo->descripcion ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $item->detalleInfraccion->lugarOcurrencia ?? 'N/A' }}</td>
                                            <td>
                                                <strong class="text-danger">
                                                    S/ {{ number_format($item->detalleInfraccion->infraccion->montoMulta, 2) }}
                                                </strong>
                                            </td>
                                            <td>
                                                @if($item->detalleInfraccion->infraccion->estadoPago == 'Pendiente')
                                                    <span class="badge bg-warning text-dark px-2 py-1">Pendiente</span>
                                                @elseif($item->detalleInfraccion->infraccion->estadoPago == 'Pagada')
                                                    <span class="badge bg-success px-2 py-1">Pagada</span>
                                                @else
                                                    <span class="badge bg-danger px-2 py-1">Vencida</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->detalleInfraccion->infraccion->fechaLimitePago)->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($infracciones->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation">
                                {{ $infracciones->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif

                    <!-- Estadísticas rápidas -->
                    <div class="row mt-4 g-3">
                        <!-- Total Validadas -->
                        <div class="col-md-4">
                            <div class="card p-3 text-center shadow-sm" style="background-color: #d1ecf1; border-left: 4px solid #17a2b8;">
                                <h3 class="mb-1">{{ $infracciones->total() }}</h3>
                                <p class="mb-0 text-muted">Total Validadas</p>
                            </div>
                        </div>
                        <!-- Pendientes de Pago -->
                        <div class="col-md-4">
                            <div class="card p-3 text-center shadow-sm" style="background-color: #fff3cd; border-left: 4px solid #ffc107;">
                                <h3 class="mb-1">{{ $infracciones->where('detalleInfraccion.infraccion.estadoPago', 'Pendiente')->count() }}</h3>
                                <p class="mb-0 text-muted">Pendientes de Pago</p>
                            </div>
                        </div>
                        <!-- Pagadas -->
                        <div class="col-md-4">
                            <div class="card p-3 text-center shadow-sm" style="background-color: #d4edda; border-left: 4px solid #28a745;">
                                <h3 class="mb-1">{{ $infracciones->where('detalleInfraccion.infraccion.estadoPago', 'Pagada')->count() }}</h3>
                                <p class="mb-0 text-muted">Pagadas</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection