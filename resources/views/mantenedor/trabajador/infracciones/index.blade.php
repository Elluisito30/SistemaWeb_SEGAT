@extends('layout.plantillaTrabajador')
@section('titulo', 'Infracciones por Validar')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <!-- Header verde claro -->
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #2d5f3f;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-exclamation-triangle me-2"></i> INFRACCIONES POR VALIDAR
                    </h5>
                </div>

                <div class="card-body p-4">

                    @if(session('datos'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Buscador y botón Ver Historial -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('trabajador.infracciones.index') }}">
                                <div class="input-group shadow-sm">
                                    <input type="text" 
                                           name="buscarpor" 
                                           class="form-control border-0" 
                                           placeholder="Buscar por documento o email del infractor..."
                                           value="{{ $buscarpor }}"
                                           style="background-color: #f8f9fa;">
                                    <button class="btn text-white" type="submit" style="background-color: #2d5f3f;">
                                        <i class="fas fa-search me-2"></i> Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('trabajador.infracciones.historial') }}" 
                               class="btn text-white shadow-sm" 
                               style="background-color: #5cb85c;">
                                <i class="fas fa-history me-2"></i> Ver Historial
                            </a>
                        </div>
                    </div>

                    <!-- Tabla de infracciones -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                            <thead style="background-color: #2d5f3f; color: white;">
                                <tr>
                                    <th>N° de ID</th>
                                    <th>Infractor</th>
                                    <th>Tipo de infracción</th>
                                    <th>Lugar</th>
                                    <th>Fecha y hora</th>
                                    <th>Evidencia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($infracciones->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay infracciones pendientes de validación</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($infracciones as $item)
                                        <tr class="shadow-sm" style="background-color: white;">
                                            <td>
                                                <span class="badge bg-dark px-3 py-2">{{ $item->id_infraccion }}</span>
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
                                            <td>{{ \Carbon\Carbon::parse($item->detalleInfraccion->fechaHora)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($item->documentoAdjunto)
                                                    <a href="{{ asset('storage/infracciones/'.$item->documentoAdjunto) }}" 
                                                       target="_blank"
                                                       class="btn btn-sm btn-info" 
                                                       title="Ver evidencia">
                                                        <i class="fas fa-image"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin adjunto</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('trabajador.infracciones.validar', $item->id_infraccion) }}" 
                                                   class="btn btn-success btn-sm" 
                                                   title="Validar infracción"
                                                   data-toggle="tooltip">
                                                    <i class="fas fa-check me-2"></i> Validar
                                                </a>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection