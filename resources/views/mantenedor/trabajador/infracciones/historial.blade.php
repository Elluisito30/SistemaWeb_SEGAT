@extends('layout.plantillaTrabajador')
@section('titulo', 'Historial de Infracciones Validadas')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">
    
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-header bg-white border-0 pt-4 pb-3">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="font-weight-bold mb-0">
            <i class="fas fa-history mr-2" style="color: #16a34a;"></i>
            Mis Infracciones Validadas
          </h4>
          <a href="{{ route('trabajador.infracciones.index') }}" 
             class="btn btn-outline-success">
            <i class="fas fa-arrow-left mr-2"></i>Volver a Pendientes
          </a>
        </div>
      </div>

      <div class="card-body p-4">
        
        <!-- Buscador -->
        <div class="row mb-4">
          <div class="col-md-8">
            <form method="GET" action="{{ route('trabajador.infracciones.historial') }}">
              <div class="input-group">
                <input type="text" 
                       name="buscarpor" 
                       class="form-control" 
                       placeholder="Buscar por documento o email del infractor..."
                       value="{{ $buscarpor }}">
                <div class="input-group-append">
                  <button class="btn btn-success" type="submit">
                    <i class="fas fa-search"></i> Buscar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Tabla de historial -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="bg-light">
              <tr>
                <th>Fecha Validación</th>
                <th>Infractor</th>
                <th>Tipo Infracción</th>
                <th>Lugar</th>
                <th>Monto Multa</th>
                <th>Estado Pago</th>
                <th>Fecha Límite</th>
              </tr>
            </thead>
            <tbody>
              @if(count($infracciones) <= 0)
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                  No has validado infracciones aún
                </td>
              </tr>
              @else
                @foreach($infracciones as $item)
                <tr>
                  <td>
                    <strong>{{ date('d/m/Y', strtotime($item->fechaHoraEmision)) }}</strong><br>
                    <small class="text-muted">{{ date('H:i', strtotime($item->fechaHoraEmision)) }}</small>
                  </td>
                  <td>
                    <div>
                      <strong>{{ $item->detalleInfraccion->contribuyente->numDocumento ?? 'N/A' }}</strong>
                    </div>
                    <small class="text-muted">
                      {{ $item->detalleInfraccion->contribuyente->email ?? 'N/A' }}
                    </small>
                  </td>
                  <td>
                    <span class="badge badge-warning">
                      {{ $item->detalleInfraccion->tipoInfraccion->descripcion ?? 'N/A' }}
                    </span>
                  </td>
                  <td>{{ $item->detalleInfraccion->lugarOcurrencia ?? 'N/A' }}</td>
                  <td>
                    <strong class="text-danger">
                      S/. {{ number_format($item->detalleInfraccion->infraccion->montoMulta, 2) }}
                    </strong>
                  </td>
                  <td>
                    @if($item->detalleInfraccion->infraccion->estadoPago == 'Pendiente')
                      <span class="badge badge-warning">Pendiente</span>
                    @elseif($item->detalleInfraccion->infraccion->estadoPago == 'Pagada')
                      <span class="badge badge-success">Pagada</span>
                    @else
                      <span class="badge badge-danger">Vencida</span>
                    @endif
                  </td>
                  <td>
                    {{ date('d/m/Y', strtotime($item->detalleInfraccion->infraccion->fechaLimitePago)) }}
                  </td>
                </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
          {{ $infracciones->links() }}
        </div>

        <!-- Estadísticas rápidas -->
        <div class="row mt-4">
          <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background: #dcfce7;">
              <div class="card-body text-center">
                <h3 class="font-weight-bold mb-1" style="color: #16a34a;">
                  {{ $infracciones->total() }}
                </h3>
                <p class="text-muted mb-0">Total Validadas</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background: #fef3c7;">
              <div class="card-body text-center">
                <h3 class="font-weight-bold mb-1" style="color: #f59e0b;">
                  {{ $infracciones->where('detalleInfraccion.infraccion.estadoPago', 'Pendiente')->count() }}
                </h3>
                <p class="text-muted mb-0">Pendientes de Pago</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background: #d1fae5;">
              <div class="card-body text-center">
                <h3 class="font-weight-bold mb-1" style="color: #10b981;">
                  {{ $infracciones->where('detalleInfraccion.infraccion.estadoPago', 'Pagada')->count() }}
                </h3>
                <p class="text-muted mb-0">Pagadas</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

@endsection