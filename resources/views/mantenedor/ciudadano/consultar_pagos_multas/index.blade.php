@extends('layout.plantillaCiudadano')
@section('titulo','Mis Pagos y Multas')
@section('contenido')

<div class="card">
  <div class="card-header">
    <h3 class="card-title">CONSULTA DE ARBITRIOS Y MULTAS</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="card-body">
    
    @if(isset($mensaje))
      <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> {{ $mensaje }}
      </div>
    @else
      
      @if(count($infracciones) <= 0)
        <div class="alert alert-success" role="alert">
          <i class="fas fa-check-circle"></i> No tiene multas ni infracciones registradas.
        </div>
      @else
        
        <!-- Información del contribuyente -->
        <div class="alert alert-light border mb-3">
          <h5><i class="fas fa-user"></i> Información del Contribuyente</h5>
          <div class="row">
            <div class="col-md-6">
              <p class="mb-1"><strong>Email:</strong> {{ $contribuyente->email }}</p>
              <p class="mb-1"><strong>N° Documento:</strong> {{ $contribuyente->numDocumento }}</p>
              <p class="mb-0"><strong>Tipo:</strong> {{ $contribuyente->tipoContribuyente ?? 'No especificado' }}</p>
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

        <!-- Resumen de multas -->
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="info-box bg-warning">
              <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Infracciones</span>
                <span class="info-box-number">{{ count($infracciones) }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box bg-danger">
              <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total a Pagar</span>
                <span class="info-box-number">S/ {{ number_format($infracciones->sum('infraccion.montoMulta'), 2) }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabla de multas -->
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">N°</th>
                <th scope="col">Tipo de Infracción</th>
                <th scope="col">Fecha y Hora</th>
                <th scope="col">Lugar</th>
                <th scope="col">Monto</th>
                <th scope="col">Fecha Límite</th>
                <th scope="col">Estado</th>
                <th scope="col">Documento</th>
              </tr>
            </thead>
            
            <tbody>
              @foreach($infracciones as $index => $detalleInfraccion)
              <tr>
                <td>{{ $index + 1 }}</td>
                
                <td>
                  <strong>{{ $detalleInfraccion->tipo->descripcion ?? 'N/A' }}</strong>
                  <br>
                  <small class="text-muted">
                    Código: {{ $detalleInfraccion->tipo->tipoInfraccion ?? '' }}
                  </small>
                </td>
                
                <td>{{ \Carbon\Carbon::parse($detalleInfraccion->fechaHora)->format('d/m/Y H:i') }}</td>
                <td>{{ $detalleInfraccion->lugarOcurrencia }}</td>
                <td>
                  <span class="badge badge-danger" style="font-size: 1rem;">
                    S/ {{ number_format($detalleInfraccion->infraccion->montoMulta, 2) }}
                  </span>
                </td>
                <td>
                  @if($detalleInfraccion->infraccion->fechaLimitePago)
                    {{ \Carbon\Carbon::parse($detalleInfraccion->infraccion->fechaLimitePago)->format('d/m/Y') }}
                    <br>
                    @if(\Carbon\Carbon::parse($detalleInfraccion->infraccion->fechaLimitePago) < now())
                      <small class="text-danger">
                        <i class="fas fa-exclamation-circle"></i> Vencido
                      </small>
                    @else
                      <small class="text-success">
                        <i class="fas fa-clock"></i> Vigente
                      </small>
                    @endif
                  @else
                    <span class="text-muted">No definido</span>
                  @endif
                </td>
                <td>
                  @if($detalleInfraccion->infraccion->estadoPago == 'Pagado')
                    <span class="badge badge-success">
                      <i class="fas fa-check-circle"></i> Pagado
                    </span>
                  @else
                    <span class="badge badge-warning">
                      <i class="fas fa-hourglass-half"></i> Pendiente
                    </span>
                  @endif
                </td>
                <td class="text-center">
                  @if($detalleInfraccion->infraccion->documentoAdjunto)
                    <a href="#" class="btn btn-sm btn-info" title="Ver documento">
                      <i class="fas fa-file-pdf"></i>
                    </a>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Información adicional -->
        <div class="alert alert-info mt-3">
          <i class="fas fa-info-circle"></i>
          <strong>Importante:</strong> 
          Para realizar el pago de sus multas, puede acercarse a las oficinas de la municipalidad 
          o realizar el pago en línea a través del portal de pagos.
        </div>
      @endif
    @endif
  </div>
</div>

@endsection

@section('script')
<script>
  // Script opcional para futuras funcionalidades
  console.log('Vista de pagos cargada correctamente');
</script>
@endsection