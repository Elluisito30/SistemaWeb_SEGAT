@extends('layout.plantillaCiudadano')
@section('titulo', 'Historial de Pagos')
@section('contenido')

<div class="container-fluid mt-3 px-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #17a2b8;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-history me-2"></i> HISTORIAL DE PAGOS REALIZADOS
                    </h5>
                </div>

                <div class="card-body">
                    @if(isset($mensaje))
                        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-info-circle me-2"></i> {{ $mensaje }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @else
                        @if($pagos->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No has realizado ningún pago aún.</h5>
                                <a href="{{ route('ciudadano.pagos.index') }}" class="btn btn-success mt-3">
                                    <i class="fas fa-credit-card me-2"></i> Registrar pago
                                </a>
                            </div>
                        @else
                            <!-- Información del contribuyente -->
                            <div class="card mb-4 shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-dark">
                                        <i class="fas fa-user me-2"></i> Información del Contribuyente
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Email:</strong> {{ $contribuyente->email }}</p>
                                            <p class="mb-0"><strong>N° Documento:</strong> {{ $contribuyente->numDocumento }}</p>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <a href="{{ route('ciudadano.pagos.index') }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-credit-card me-1"></i> Registrar nuevo pago
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumen de pagos -->
                            <div class="row mb-4 g-3">
                                <div class="col-md-6">
                                    <div class="card p-3" style="background-color: #d4edda; border-left: 4px solid #28a745;">
                                        <h3 class="mb-1 text-success">{{ $pagos->total() }}</h3>
                                        <p class="mb-0 text-muted">Total de Pagos Realizados</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card p-3" style="background-color: #d1ecf1; border-left: 4px solid #17a2b8;">
                                        <h3 class="mb-1 text-info">S/ {{ number_format($pagos->sum('montoPagado'), 2) }}</h3>
                                        <p class="mb-0 text-muted">Monto Total Pagado</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de historial -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                                    <thead style="background-color: #17a2b8; color: white;">
                                        <tr>
                                            <th>Fecha Pago</th>
                                            <th>N° Infracción</th>
                                            <th>Tipo de Infracción</th>
                                            <th>Monto Pagado</th>
                                            <th>Método de Pago</th>
                                            <th>N° Operación</th>
                                            <th>Comprobante</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pagos as $pago)
                                        <tr class="shadow-sm" style="background-color: white;">
                                            <td>
                                                <strong>{{ \Carbon\Carbon::parse($pago->fechaPago)->format('d/m/Y') }}</strong><br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($pago->fechaPago)->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-dark px-2 py-1">#{{ $pago->id_infraccion }}</span>
                                            </td>
                                            <td class="text-start">
                                                {{ $pago->infraccion->detalleInfraccion->tipo->descripcion ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <strong class="text-success">S/ {{ number_format($pago->montoPagado, 2) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info px-2 py-1">{{ $pago->metodoPago }}</span>
                                            </td>
                                            <td>
                                                {{ $pago->numeroOperacion ?? '—' }}
                                                @if($pago->entidadFinanciera)
                                                    <br><small class="text-muted">{{ $pago->entidadFinanciera }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($pago->comprobanteAdjunto)
                                                    <a href="{{ asset('storage/comprobantes/' . $pago->comprobanteAdjunto) }}" 
                                                       target="_blank"
                                                       class="btn btn-sm btn-primary" 
                                                       title="Ver comprobante">
                                                        <i class="fas fa-file-download"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($pagos->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    <nav aria-label="Page navigation">
                                        {{ $pagos->links('pagination::bootstrap-4') }}
                                    </nav>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
