@extends('layout.plantillaCiudadano')
@section('titulo', 'Listado de Solicitudes de Limpieza')
@section('contenido')

<div class="container-fluid mt-3 px-4">
    <!-- Información del Ciudadano -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3" style="color: #2d5f3f;">
                        <i class="fas fa-user-circle"></i> Información del Ciudadano
                    </h5>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Nombre:</strong> {{ Auth::user()->name ?? 'Usuario' }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ Auth::user()->email ?? 'No disponible' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>DNI:</strong> {{ Auth::user()->contribuyente->numDocumento ?? 'No disponible' }}</p>
                    <p class="mb-2"><strong>Distrito:</strong> Trujillo</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de Solicitudes -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background-color: #2d5f3f;">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total de Solicitudes</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $solicitud->total() }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background-color: #dc3545;">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Prioridad Alta</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $solicitud->where('prioridad', 'ALTA')->count() }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background-color: #ffc107;">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Prioridad Media</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $solicitud->where('prioridad', 'MEDIA')->count() }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background-color: #5cb85c;">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Prioridad Baja</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $solicitud->where('prioridad', 'BAJA')->count() }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Solicitudes -->
    <div class="card shadow-sm border-0">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #2d5f3f;">
            <h5 class="font-weight-bold m-0">
                <i class="fas fa-folder-open me-2"></i> MIS SOLICITUDES DE LIMPIEZA
            </h5>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="{{ route('ciudadano.solicitud.create') }}" class="btn btn-lg text-white shadow-sm" style="background-color: #5cb85c;">
                        <i class="fas fa-plus-circle me-1"></i> Nueva Solicitud
                    </a>
                </div>
                <div class="col-md-6">
                    <form class="form-inline justify-content-end" method="GET">
                        <div class="input-group shadow-sm">
                            <input name="buscarpor" class="form-control border-0" type="search" placeholder="Buscar por zona" aria-label="Search" value="{{ $buscarpor }}" style="background-color: #f8f9fa;">
                            <div class="input-group-append">
                                <button class="btn text-white" type="submit" style="background-color: #2d5f3f;">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="mensaje">
                @if (session('datos'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('datos') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle" style="border-collapse: separate; border-spacing: 0 10px;">
                    <thead style="background-color: #2d5f3f; color: white;">
                        <tr>
                            <th class="border-0">Código</th>
                            <th class="border-0">Zona</th>
                            <th class="border-0">Tipo de Servicio</th> {{-- ✅ CAMBIADO --}}
                            <th class="border-0">Prioridad</th>
                            <th class="border-0">Fecha Tentativa</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($solicitud) <= 0)
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay solicitudes registradas</p>
                                </td>
                            </tr>
                        @else
                            @foreach($solicitud as $itemsolicitud)
                                <tr class="shadow-sm" style="background-color: white;">
                                    <td class="align-middle">
                                        <span class="badge px-3 py-2" style="background-color: #2d5f3f; color: white;">
                                            {{ $itemsolicitud->id_solicitud }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <i class="fas fa-map-marker-alt me-1" style="color: #2d5f3f;"></i>
                                        {{ $itemsolicitud->detalleSolicitud->areaVerde->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="align-middle"> 
                                        {{ $itemsolicitud->servicio->descripcionServicio ?? 'N/A' }}
                                    </td>
                                    <td class="align-middle">
                                        @if($itemsolicitud->prioridad == 'ALTA')
                                            <span class="badge badge-danger px-3 py-2">
                                                <i class="fas fa-exclamation-circle"></i> ALTA
                                            </span>
                                        @elseif($itemsolicitud->prioridad == 'MEDIA')
                                            <span class="badge badge-warning px-3 py-2">
                                                <i class="fas fa-exclamation-triangle"></i> MEDIA
                                            </span>
                                        @else
                                            <span class="badge badge-info px-3 py-2">
                                                <i class="fas fa-info-circle"></i> BAJA
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <i class="far fa-calendar-alt text-muted me-1"></i>
                                        {{ date('d/m/Y', strtotime($itemsolicitud->fechaTentativaEjecucion)) }}
                                    </td>
                                    <td class="align-middle"> 
                                        @switch($itemsolicitud->estado)
                                            @case('registrada')
                                                <span class="badge bg-info px-3 py-2">
                                                    <i class="fas fa-file-alt me-1"></i> Registrada
                                                </span>
                                                @break
                                            @case('en_atencion')
                                                <span class="badge bg-warning px-3 py-2">
                                                    <i class="fas fa-user-clock me-1"></i> En atención
                                                </span>
                                                @break
                                            @case('atendida')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i> Atendida
                                                </span>
                                                @break
                                            @case('rechazada')
                                                <span class="badge bg-danger px-3 py-2">
                                                    <i class="fas fa-times-circle me-1"></i> Ninguno
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary px-3 py-2">Desconocido</span>
                                        @endswitch
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('ciudadano.solicitud.edit', $itemsolicitud->id_solicitud) }}" 
                                               class="btn btn-info btn-sm" 
                                               data-toggle="tooltip" 
                                               title="Editar solicitud">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('ciudadano.solicitud.confirmar', $itemsolicitud->id_solicitud) }}" 
                                               class="btn btn-danger btn-sm" 
                                               data-toggle="tooltip" 
                                               title="Eliminar solicitud">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $solicitud->links() }}
            </div>
        </div>
    </div>

    <!-- Nota Informativa -->
    <div class="alert shadow-sm mt-4" role="alert" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
        <i class="fas fa-info-circle"></i>
        <strong>Importante:</strong> Las solicitudes de limpieza serán procesadas según su prioridad. 
        Recibirá notificaciones sobre el estado de cada solicitud.
    </div>
</div>
@endsection

@section('js')
<script>
    setTimeout(function () {
        let mensaje = document.querySelector('#mensaje');
        if (mensaje) mensaje.remove();
    }, 3000);
    
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection