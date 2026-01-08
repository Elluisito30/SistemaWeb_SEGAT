@extends('layout.plantillaCiudadano')
@section('titulo', 'Mis Notificaciones')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-1 row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #dc3545;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-bell mr-2"></i> MIS NOTIFICACIONES
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <form method="GET" action="{{ route('ciudadano.notificaciones.index') }}" class="w-100">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label for="fecha_desde" class="form-label fw-bold">Fecha desde:</label>
                                    <input type="date" 
                                           name="fecha_desde" 
                                           id="fecha_desde"
                                           class="form-control" 
                                           value="{{ request('fecha_desde') }}"
                                           max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_hasta" class="form-label fw-bold">Fecha hasta:</label>
                                    <input type="date" 
                                           name="fecha_hasta" 
                                           id="fecha_hasta"
                                           class="form-control" 
                                           value="{{ request('fecha_hasta') }}"
                                           max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="d-grid w-100 mr-2">
                                        <button type="submit" class="btn text-white d-flex align-items-center" style="background-color: #dc3545; height: 38px;">
                                            <i class="fas fa-search mr-2"></i> Buscar
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-light btn-sm" onclick="marcarTodasLeidas()" style="background-color: #567ff1e3; height: 38px; white-space: nowrap;">
                                        <i class="fas fa-check-double mr-2"></i> Marcar todas como leídas
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                            <thead style="background-color: #56f17ae3; color: black;">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Título</th>
                                    <th>Mensaje</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notificaciones as $notif)
                                    <tr class="shadow-sm" style="background-color: white;">
                                        <td>
                                            @php
                                                $iconos = [
                                                    'multa' => 'fa-exclamation-triangle text-danger',
                                                    'solicitud' => 'fa-clipboard-list text-primary',
                                                    'pago' => 'fa-dollar-sign text-success',
                                                    'general' => 'fa-info-circle text-info'
                                                ];
                                                $icon = $iconos[$notif->tipo] ?? $iconos['general'];
                                            @endphp
                                            <i class="fas {{ $icon }} fa-2x"></i>
                                        </td>
                                        <td class="text-start">{{ $notif->titulo }}</td>
                                        <td class="text-start">{{ $notif->mensaje }}</td>
                                        <td>{{ $notif->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if(!$notif->leida)
                                                <span class="badge bg-warning text-dark px-2 py-1">
                                                    <i class="fas fa-envelope mr-2"></i> Nueva
                                                </span>
                                            @else
                                                <span class="badge bg-secondary px-2 py-1">
                                                    <i class="fas fa-envelope-open-text mr-2"></i> Leída
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="far fa-bell-slash fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No tienes notificaciones</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($notificaciones->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation">
                                {{ $notificaciones->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function marcarTodasLeidas() {
    if (confirm('¿Está seguro de marcar todas las notificaciones como leídas?')) {
        fetch('{{ route('ciudadano.notificaciones.marcarTodas') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al marcar notificaciones.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error. Intente nuevamente.');
        });
    }
}
</script>

@endsection