@extends('layout.plantillaCiudadano')
@section('titulo', 'Registrar Pago de Multa')
@section('contenido')

<div class="container-fluid mt-3 px-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #28a745;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-money-bill-wave me-2"></i> REGISTRAR PAGO DE MULTA
                    </h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(isset($mensaje))
                        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-info-circle me-2"></i> {{ $mensaje }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @else
                        @if($infracciones->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h5 class="text-muted">No tiene multas pendientes de pago.</h5>
                                <p class="text-muted">Todas sus infracciones están al día.</p>
                                <a href="{{ route('ciudadano.pagos.historial') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-history me-2"></i> Ver historial de pagos
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
                                            <a href="{{ route('ciudadano.pagos.historial') }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-history me-1"></i> Ver historial de pagos
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumen de deuda -->
                            <div class="row mb-4 g-3">
                                <div class="col-md-4">
                                    <div class="card p-3" style="background-color: #ffc107; color: #2d5f3f; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-dark rounded-circle p-2 me-3">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Multas pendientes:</h6>
                                                <h3 class="mb-0">{{ $infracciones->count() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card p-3" style="background-color: #dc3545; color: white; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-dark rounded-circle p-2 me-3">
                                                <i class="fas fa-dollar-sign text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Monto total a pagar:</h6>
                                                <h3 class="mb-0">S/ {{ number_format($infracciones->sum('infraccion.montoMulta'), 2) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de multas pendientes -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                                    <thead style="background-color: #28a745; color: white;">
                                        <tr>
                                            <th>N°</th>
                                            <th>Tipo de Infracción</th>
                                            <th>Lugar</th>
                                            <th>Fecha</th>
                                            <th>Monto a Pagar</th>
                                            <th>Fecha Límite</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($infracciones as $index => $detalleInfraccion)
                                        <tr class="shadow-sm" style="background-color: white;">
                                            <td>
                                                <span class="badge bg-dark px-2 py-1">#{{ $detalleInfraccion->infraccion->id_infraccion }}</span>
                                            </td>
                                            <td class="text-start">
                                                <strong>{{ $detalleInfraccion->tipo->descripcion ?? 'N/A' }}</strong>
                                            </td>
                                            <td>{{ $detalleInfraccion->lugarOcurrencia }}</td>
                                            <td>{{ \Carbon\Carbon::parse($detalleInfraccion->fechaHora)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-danger px-3 py-2" style="font-size: 1em;">
                                                    S/ {{ number_format($detalleInfraccion->infraccion->montoMulta, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($detalleInfraccion->infraccion->fechaLimitePago)->format('d/m/Y') }}<br>
                                                @if(\Carbon\Carbon::parse($detalleInfraccion->infraccion->fechaLimitePago) < now())
                                                    <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Vencido</small>
                                                @else
                                                    <small class="text-success"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($detalleInfraccion->infraccion->fechaLimitePago)->diffForHumans() }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('ciudadano.pagos.create', $detalleInfraccion->infraccion->id_infraccion) }}" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-credit-card me-1"></i> Pagar
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Nota informativa -->
                            <div class="alert alert-info mt-4 shadow-sm" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Importante:</strong> 
                                Una vez registrado el pago, la multa será marcada automáticamente como pagada. 
                                Asegúrese de ingresar correctamente los datos de la transacción y adjuntar el comprobante de pago.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
