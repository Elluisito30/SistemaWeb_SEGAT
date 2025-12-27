@extends('layout.plantillaTrabajador')
@section('titulo', 'Gestionar Solicitudes')
@section('contenido')

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i>Gestión de Solicitudes de Limpieza</h3>
        </div>
        <div class="card-body">
            
            @if(session('datos'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('datos') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            <!-- Filtros -->
            <form method="GET" action="{{ route('trabajador.solicitudes.index') }}">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" name="buscarpor" class="form-control" placeholder="Buscar por área verde..." value="{{ $buscarpor }}">
                    </div>
                    <div class="col-md-3">
                        <select name="estado" class="form-control">
                            <option value="">-- Todos los estados --</option>
                            <option value="registrada" {{ $estado == 'registrada' ? 'selected' : '' }}>Registrada</option>
                            <option value="en atención" {{ $estado == 'en atención' ? 'selected' : '' }}>En Atención</option>
                            <option value="atendida" {{ $estado == 'atendida' ? 'selected' : '' }}>Atendida</option>
                            <option value="rechazada" {{ $estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>N° Solicitud</th>
                            <th>Área Verde</th>
                            <th>Contribuyente</th>
                            <th>Servicio</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Monto</th>
                            <th>Fecha Programada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($solicitudes as $item)
                        <tr>
                            <td>{{ $item->id_solicitud }}</td>
                            <td>{{ $item->detalleSolicitud->areaVerde->nombre ?? 'N/A' }}</td>
                            <td>{{ $item->detalleSolicitud->contribuyente->nombres ?? 'N/A' }}</td>
                            <td>{{ $item->servicio->nombre ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ $item->prioridad == 'ALTA' ? 'danger' : ($item->prioridad == 'MEDIA' ? 'warning' : 'info') }}">
                                    {{ $item->prioridad }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $item->estado == 'registrada' ? 'secondary' : ($item->estado == 'en atención' ? 'primary' : ($item->estado == 'atendida' ? 'success' : 'danger')) }}">
                                    {{ ucfirst($item->estado) }}
                                </span>
                            </td>
                            <td>{{ $item->monto ? 'S/ ' . number_format($item->monto, 2) : '-' }}</td>
                            <td>{{ $item->fechaProgramada ? \Carbon\Carbon::parse($item->fechaProgramada)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('trabajador.solicitudes.edit', $item->id_solicitud) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Gestionar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay solicitudes registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $solicitudes->appends(['buscarpor' => $buscarpor, 'estado' => $estado])->links() }}
            </div>

        </div>
    </div>
</div>

@endsection
