@extends('layout.plantillaTrabajador')
@section('titulo', 'Gestionar Solicitudes')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
            <!-- Card contenedor -->
            <div class="card shadow-sm border-0">
                <!-- Header verde -->
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #68b76f;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-clipboard-list me-2"></i> GESTIÓN DE SOLICITUDES DE LIMPIEZA
                    </h5>
                </div>

                <!-- Cuerpo del card -->
                <div class="card-body p-4">

                    @if(session('datos'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filtros en una fila -->
                    <form method="GET" action="{{ route('trabajador.solicitudes.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <input type="text" 
                                       name="buscarpor" 
                                       class="form-control" 
                                       placeholder="Buscar por área verde..." 
                                       value="{{ $buscarpor }}">
                            </div>
                            <div class="col-md-3">
                                <select name="estado" class="form-select">
                                    <option value="">-- Todos los estados --</option>
                                    <option value="registrada" {{ $estado == 'registrada' ? 'selected' : '' }}>Registrada</option>
                                    <option value="en atención" {{ $estado == 'en atención' ? 'selected' : '' }}>En Atención</option>
                                    <option value="atendida" {{ $estado == 'atendida' ? 'selected' : '' }}>Atendida</option>
                                    <option value="rechazada" {{ $estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn text-white w-60" style="background-color: #2d5f3f;">
                                    <i class="fas fa-search me-2"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                            <thead style="background-color: #2d5f3f; color: white;">
                                <tr>
                                    <th>N° de Solicitud</th>
                                    <th>Área Verde</th>
                                    <th>Contribuyente</th>
                                    <th>Tipo de Servicio</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Monto</th>
                                    <th>Fecha programada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($solicitudes as $item)
                                    <tr class="shadow-sm" style="background-color: white;">
                                        <td>
                                            <span class="badge bg-dark px-3 py-2">{{ $item->id_solicitud }}</span>
                                        </td>
                                        <td class="text-start">
                                            <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                            {{ $item->detalleSolicitud->areaVerde->nombre ?? 'N/A' }}
                                        </td>
                                        <td class="text-start">
                                            <i class="fas fa-id-card text-muted me-1"></i>
                                            {{ $item->detalleSolicitud->contribuyente->numDocumento ?? 'N/A' }}
                                        </td>
                                        <td>{{ $item->servicio->descripcionServicio ?? 'N/A' }}</td>
                                        <td>
                                            @if($item->prioridad == 'ALTA')
                                                <span class="badge bg-danger px-3 py-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i> ALTA
                                                </span>
                                            @elseif($item->prioridad == 'MEDIA')
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="fas fa-exclamation-triangle me-1"></i> MEDIA
                                                </span>
                                            @else
                                                <span class="badge bg-info px-3 py-2">
                                                    <i class="fas fa-info-circle me-1"></i> BAJA
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($item->estado)
                                                @case('registrada')
                                                    <span class="badge bg-secondary px-3 py-2">
                                                        <i class="fas fa-file-alt me-1"></i> Registrada
                                                    </span>
                                                    @break
                                                @case('en atención')
                                                    <span class="badge bg-primary px-3 py-2">
                                                        <i class="fas fa-user-clock me-1"></i> En Atención
                                                    </span>
                                                    @break
                                                @case('atendida')
                                                    <span class="badge bg-success px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i> Atendida
                                                    </span>
                                                    @break
                                                @case('rechazada')
                                                    <span class="badge bg-danger px-3 py-2">
                                                        <i class="fas fa-times-circle me-1"></i> Rechazada
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark px-3 py-2">Desconocido</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $item->monto ? 'S/ ' . number_format($item->monto, 2) : '-' }}
                                        </td>
                                        <td>
                                            {{ $item->fechaProgramada ? \Carbon\Carbon::parse($item->fechaProgramada)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('trabajador.solicitudes.edit', $item->id_solicitud) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="Gestionar solicitud"
                                               data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay solicitudes registradas</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($solicitudes->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation">
                                {{ $solicitudes->appends(['buscarpor' => $buscarpor, 'estado' => $estado])->links('pagination::bootstrap-4') }}
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