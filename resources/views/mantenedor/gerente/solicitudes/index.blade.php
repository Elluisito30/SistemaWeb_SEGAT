@extends('layout.plantillaGerente')
@section('titulo', 'Reporte Solicitudes')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #198754;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-clipboard-list me-2"></i> LISTADO DE SOLICITUDES DE SERVICIO
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                            <thead style="background-color: #198754; color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Servicio</th>
                                    <th>Prioridad</th>
                                    <th>Descripción</th>
                                    <th>Fecha Tentativa</th>
                                    <th>Estado</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($solicitudes as $sol)
                                    <tr class="shadow-sm" style="background-color: white;">
                                        <td>
                                            <span class="badge bg-dark px-2 py-1">#{{ $sol->id_solicitud }}</span>
                                        </td>
                                        <td>{{ $sol->descripcionServicio ?? 'N/A' }}</td>
                                        <td>
                                            @if($sol->prioridad == 'ALTA')
                                                <span class="badge bg-danger px-2 py-1">
                                                    <i class="fas fa-exclamation-circle me-1"></i> Alta
                                                </span>
                                            @elseif($sol->prioridad == 'MEDIA')
                                                <span class="badge bg-warning text-dark px-2 py-1">
                                                    <i class="fas fa-exclamation-triangle me-1"></i> Media
                                                </span>
                                            @else
                                                <span class="badge bg-success px-2 py-1">
                                                    <i class="fas fa-info-circle me-1"></i> Baja
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            {{ Str::limit($sol->descripcion, 50) ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($sol->fechaTentativaEjecucion)->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            @switch(strtolower($sol->estado))
                                                @case('registrada')
                                                    <span class="badge bg-secondary px-2 py-1">Registrada</span>
                                                    @break
                                                @case('en_atencion')
                                                    <span class="badge bg-primary px-2 py-1">En Atención</span>
                                                    @break
                                                @case('atendida')
                                                    <span class="badge bg-success px-2 py-1">Atendida</span>
                                                    @break
                                                @case('rechazado')
                                                    <span class="badge bg-danger px-2 py-1">Rechazado</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark px-2 py-1">{{ ucfirst($sol->estado) }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($sol->monto)
                                                <span class="badge bg-success px-3 py-2">
                                                    S/ {{ number_format($sol->monto, 2) }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
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
                                {{ $solicitudes->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection