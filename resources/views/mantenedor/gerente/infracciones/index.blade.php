@extends('layout.plantillaGerente')
@section('titulo', 'Reporte Infracciones')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #dc3545;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-exclamation-circle me-2"></i> LISTADO DE INFRACCIONES Y MULTAS
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                            <thead style="background-color: #dc3545; color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Lugar</th>
                                    <th>Fecha/Hora</th>
                                    <th>Monto</th>
                                    <th>Estado Pago</th>
                                    <th>Evidencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($infracciones as $inf)
                                    <tr class="shadow-sm" style="background-color: white;">
                                        <td>
                                            <span class="badge bg-dark px-2 py-1">#{{ $inf->id_infraccion }}</span>
                                        </td>
                                        <td class="text-start">
                                            <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                            {{ $inf->lugarOcurrencia }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($inf->fechaHora)->format('d/m/Y H:i') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-danger px-3 py-2">
                                                S/ {{ number_format($inf->montoMulta, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(strtolower($inf->estadoPago) == 'pagado')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i> Pagado
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i> Pendiente
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($inf->documentoAdjunto)
                                                <a href="{{ asset('storage/infracciones/' . $inf->documentoAdjunto) }}" 
                                                   target="_blank"
                                                   class="btn btn-sm btn-info"
                                                   title="Ver evidencia">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay infracciones registradas</p>
                                        </td>
                                    </tr>
                                @endforelse
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