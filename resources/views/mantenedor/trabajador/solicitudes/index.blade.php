@extends('layout.plantillaTrabajador')
@section('titulo', 'Solicitudes de Limpieza')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">
    
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-header bg-white border-0 pt-4 pb-3">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="font-weight-bold mb-0">
            <i class="fas fa-clipboard-list mr-2" style="color: #16a34a;"></i>
            Solicitudes de Limpieza
          </h4>
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

        <!-- Filtros -->
        <div class="row mb-4">
          <div class="col-md-8">
            <form method="GET" action="{{ route('trabajador.solicitudes.index') }}">
              <div class="input-group">
                <input type="text" 
                       name="buscarpor" 
                       class="form-control" 
                       placeholder="Buscar por área verde..."
                       value="{{ $buscarpor }}">
                <select name="estado" class="form-control ml-2" style="max-width: 200px;">
                  <option value="">Todos los estados</option>
                  <option value="registrada" {{ $estado == 'registrada' ? 'selected' : '' }}>Registrada</option>
                  <option value="en atención" {{ $estado == 'en atención' ? 'selected' : '' }}>En Atención</option>
                  <option value="atendida" {{ $estado == 'atendida' ? 'selected' : '' }}>Atendida</option>
                  <option value="rechazado" {{ $estado == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
                <div class="input-group-append">
                  <button class="btn btn-success" type="submit">
                    <i class="fas fa-search"></i> Buscar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Tabla de solicitudes -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="bg-light">
              <tr>
                <th>ID</th>
                <th>Área Verde</th>
                <th>Servicio</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Fecha Tentativa</th>
                <th>Monto</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @if(count($solicitudes) <= 0)
              <tr>
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                  No hay solicitudes registradas
                </td>
              </tr>
              @else
                @foreach($solicitudes as $item)
                <tr>
                  <td><strong>#{{ $item->id_solicitud }}</strong></td>
                  <td>
                    <i class="fas fa-map-marker-alt mr-2 text-success"></i>
                    {{ $item->detalleSolicitud->areaVerde->nombre ?? 'N/A' }}
                  </td>
                  <td>{{ $item->servicio->descripcion ?? 'N/A' }}</td>
                  <td>
                    @if($item->prioridad == 'ALTA')
                      <span class="badge badge-danger">ALTA</span>
                    @elseif($item->prioridad == 'MEDIA')
                      <span class="badge badge-warning">MEDIA</span>
                    @else
                      <span class="badge badge-info">BAJA</span>
                    @endif
                  </td>
                  <td>
                    @if($item->estado == 'registrada')
                      <span class="badge badge-secondary">Registrada</span>
                    @elseif($item->estado == 'en atención')
                      <span class="badge badge-primary">En Atención</span>
                    @elseif($item->estado == 'atendida')
                      <span class="badge badge-success">Atendida</span>
                    @else
                      <span class="badge badge-danger">Rechazado</span>
                    @endif
                  </td>
                  <td>{{ date('d/m/Y', strtotime($item->fechaTentativaEjecucion)) }}</td>
                  <td>
                    @if($item->monto)
                      S/. {{ number_format($item->monto, 2) }}
                    @else
                      <span class="text-muted">Sin programar</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <a href="{{ route('trabajador.solicitudes.edit', $item->id_solicitud) }}" 
                       class="btn btn-sm btn-primary" 
                       title="Gestionar">
                      <i class="fas fa-edit"></i>
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
          {{ $solicitudes->links() }}
        </div>

      </div>
    </div>

  </div>
</section>

@endsection