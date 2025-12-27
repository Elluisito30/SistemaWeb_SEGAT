@extends('layout.plantillaTrabajador')
@section('titulo', 'Infracciones por Validar')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">
    
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-header bg-white border-0 pt-4 pb-3">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="font-weight-bold mb-0">
            <i class="fas fa-exclamation-triangle mr-2" style="color: #16a34a;"></i>
            Infracciones por Validar
          </h4>
          <a href="{{ route('trabajador.infracciones.historial') }}" 
             class="btn btn-outline-success">
            <i class="fas fa-history mr-2"></i>Ver Historial
          </a>
        </div>
      </div>

      <div class="card-body p-4">
        
        @if(session('datos'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle mr-2"></i>{{ session('datos') }}
          <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
          <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
        </div>
        @endif

        <!-- Buscador -->
        <div class="row mb-4">
          <div class="col-md-8">
            <form method="GET" action="{{ route('trabajador.infracciones.index') }}">
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

        <!-- Tabla de infracciones -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="bg-light">
              <tr>
                <th>ID</th>
                <th>Infractor</th>
                <th>Tipo Infracción</th>
                <th>Lugar</th>
                <th>Fecha/Hora</th>
                <th>Evidencia</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @if(count($infracciones) <= 0)
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                  No hay infracciones pendientes de validación
                </td>
              </tr>
              @else
                @foreach($infracciones as $item)
                <tr>
                  <td><strong>#{{ $item->id_infraccion }}</strong></td>
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
                      {{ $item->detalleInfraccion->tipo->descripcion ?? 'N/A' }}
                    </span>
                  </td>
                  <td>{{ $item->detalleInfraccion->lugarOcurrencia ?? 'N/A' }}</td>
                  <td>{{ date('d/m/Y H:i', strtotime($item->detalleInfraccion->fechaHora)) }}</td>
                  <td class="text-center">
                    @if($item->documentoAdjunto)
                      <a href="{{ asset('storage/infracciones/'.$item->documentoAdjunto) }}" 
                         target="_blank"
                         class="btn btn-sm btn-info">
                        <i class="fas fa-image"></i>
                      </a>
                    @else
                      <span class="text-muted">Sin adjunto</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <a href="{{ route('trabajador.infracciones.validar', $item->id_infraccion) }}" 
                       class="btn btn-sm btn-success" 
                       title="Validar Infracción">
                      <i class="fas fa-check"></i> Validar
                    </a>
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

      </div>
    </div>

  </div>
</section>

@endsection