@extends('layout.plantillaCiudadano')
@section('titulo', 'Mis Pagos y Multas')
@section('contenido')

<div class="container-fluid mt-3 px-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #2d5f3f;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-file-invoice-dollar me-2"></i> CONSULTA DE ARBITRIOS Y MULTAS
                    </h5>
                </div>

                <div class="card-body">
                    @if(isset($mensaje))
                        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-info-circle me-2"></i> {{ $mensaje }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @else
                        @if($infracciones->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h5 class="text-muted">No tiene multas ni infracciones registradas.</h5>
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
                                            <p class="mb-1"><strong>N° Documento:</strong> {{ $contribuyente->numDocumento }}</p>
                                            <p class="mb-0"><strong>Tipo:</strong> {{ $contribuyente->tipoContribuyente == 'N' ? 'Natural' : 'Jurídico' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            @if($contribuyente->domicilio)
                                                <p class="mb-1"><strong>Domicilio:</strong> {{ $contribuyente->domicilio->direccionDomi }}</p>
                                                <p class="mb-0"><strong>Distrito:</strong> {{ $contribuyente->domicilio->distrito->descripcion ?? 'N/A' }}</p>
                                            @else
                                                <p class="mb-0 text-muted"><em>Sin domicilio registrado</em></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 g-3">
                                <!-- Total Infracciones -->
                                <div class="col-md-4">
                                    <div class="card p-3" style="background-color: #00b0cc; color: white; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-dark rounded-circle p-2 me-3">
                                                <i class="fas fa-clipboard-list text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Total de infracciones:</h6>
                                                <h3 class="mb-0">{{ $infracciones->count() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pendientes Validación -->
                                <div class="col-md-4">
                                    <div class="card p-3" style="background-color: #ffc107; color: #2d5f3f; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-dark rounded-circle p-2 me-3">
                                                <i class="fas fa-clock text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Pendientes de validación:</h6>
                                                <h3 class="mb-0">{{ $infracciones->filter(fn($i) => !$i->registroInfraccion)->count() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total a Pagar -->
                                <div class="col-md-4">
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

                            <!-- Tabla de multas -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                                    <thead style="background-color: #2d5f3f; color: white;">
                                        <tr>
                                            <th>N°</th>
                                            <th>Tipo de Infracción</th>
                                            <th>Fecha y Hora</th>
                                            <th>Lugar</th>
                                            <th>Monto</th>
                                            <th>Fecha Límite</th>
                                            <th>Estado</th>
                                            <th>Documento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($infracciones as $index => $detalleInfraccion)
                                        <tr class="shadow-sm" style="background-color: white;">
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-start">
                                                <strong>{{ $detalleInfraccion->tipo->descripcion ?? 'N/A' }}</strong><br>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($detalleInfraccion->fechaHora)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $detalleInfraccion->lugarOcurrencia }}</td>
                                            <td>
                                                @if($detalleInfraccion->infraccion->montoMulta > 0)
                                                    <span class="badge bg-danger px-2 py-1">
                                                        S/ {{ number_format($detalleInfraccion->infraccion->montoMulta, 2) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary px-2 py-1">
                                                        <i class="fas fa-clock me-1"></i> En revisión
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($detalleInfraccion->infraccion->fechaLimitePago)
                                                    {{ \Carbon\Carbon::parse($detalleInfraccion->infraccion->fechaLimitePago)->format('d/m/Y') }}<br>
                                                    @if(\Carbon\Carbon::parse($detalleInfraccion->infraccion->fechaLimitePago) < now())
                                                        <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Vencido</small>
                                                    @else
                                                        <small class="text-success"><i class="fas fa-check-circle"></i> Vigente</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Pendiente</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($detalleInfraccion->registroInfraccion)
                                                    @if($detalleInfraccion->infraccion->estadoPago == 'Pagada')
                                                        <span class="badge bg-success px-2 py-1"><i class="fas fa-check me-1"></i> Pagada</span>
                                                    @elseif($detalleInfraccion->infraccion->estadoPago == 'Vencida')
                                                        <span class="badge bg-danger px-2 py-1"><i class="fas fa-times me-1"></i> Vencida</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-hourglass-half me-1"></i> Pendiente</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary px-2 py-1"><i class="fas fa-clock me-1"></i> Sin validar</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($detalleInfraccion->infraccion->documentoAdjunto)
                                                    <a href="{{ asset('storage/infracciones/' . $detalleInfraccion->infraccion->documentoAdjunto) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Ver documento">
                                                        <i class="fas fa-file-pdf"></i>
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

                            <!-- Nota informativa -->
                            <div class="alert alert-info mt-4 text-center shadow-sm" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Importante:</strong> 
                                Para realizar el pago de sus multas, puede acercarse a las oficinas de la municipalidad 
                                o realizar el pago en línea a través del portal de pagos.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    console.log('Vista de pagos cargada correctamente');
</script>
@endsection