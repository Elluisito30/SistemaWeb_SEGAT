@extends('layout.plantillaTrabajador')
@section('titulo', 'Programar Solicitud')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #ffc107;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-calendar-alt me-2"></i> PROGRAMAR / CAMBIAR ESTADO DE SOLICITUD
                    </h5>
                </div>

                <div class="card-body p-4">

                    <!-- Información de la Solicitud -->
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header" style="background-color: #e9ecef;">
                            <h6 class="mb-0 text-dark">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                <strong>Información de la Solicitud N° {{ $solicitud->id_solicitud }}</strong>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Área Verde:</strong> {{ $solicitud->detalleSolicitud->areaVerde->nombre ?? 'N/A' }}</p>
                                    <p class="mb-2"><strong>Contribuyente (DNI):</strong> {{ $solicitud->detalleSolicitud->contribuyente->numDocumento ?? 'N/A' }}</p>
                                    <p class="mb-2"><strong>Servicio:</strong> {{ $solicitud->servicio->descripcionServicio ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                                    <p class="mb-2">
                                        <strong>Prioridad:</strong>
                                        @if($solicitud->prioridad == 'ALTA')
                                            <span class="badge bg-danger px-2 py-1">
                                                <i class="fas fa-exclamation-circle me-1"></i> ALTA
                                            </span>
                                        @elseif($solicitud->prioridad == 'MEDIA')
                                            <span class="badge bg-warning text-dark px-2 py-1">
                                                <i class="fas fa-exclamation-triangle me-1"></i> MEDIA
                                            </span>
                                        @else
                                            <span class="badge bg-info px-2 py-1">
                                                <i class="fas fa-info-circle me-1"></i> BAJA
                                            </span>
                                        @endif
                                    </p>
                                    <p class="mb-0">
                                        <strong>Fecha Tentativa:</strong> 
                                        {{ \Carbon\Carbon::parse($solicitud->fechaTentativaEjecucion)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('trabajador.solicitudes.update', $solicitud->id_solicitud) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado <span class="text-danger">*</span></label>
                                    <select name="estado" id="estado" class="form-control select-wide @error('estado') is-invalid @enderror" required>
                                        <option value="registrada" {{ $solicitud->estado == 'registrada' ? 'selected' : '' }}>Registrada</option>
                                        <option value="en_atencion" {{ $solicitud->estado == 'en_atencion' ? 'selected' : '' }}>En Atención</option>
                                        <option value="atendida" {{ $solicitud->estado == 'atendida' ? 'selected' : '' }}>Atendida</option>
                                        <option value="rechazada" {{ $solicitud->estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i> Al asignar monto y fecha, el estado cambia automáticamente a "En Atención".
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="text-primary mb-3">
                            <i class="fas fa-calendar-check me-2"></i> Programación (Opcional)
                        </h5>
                        <p class="text-muted mb-4">Asigne monto y fecha para programar la solicitud</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="monto">Monto (S/)</label>
                                    <input type="number" 
                                           name="monto" 
                                           id="monto" 
                                           step="0.01" 
                                           min="0" 
                                           max="99999.99" 
                                           class="form-control @error('monto') is-invalid @enderror" 
                                           value="{{ old('monto', $solicitud->monto) }}"
                                           placeholder="0.00">
                                    @error('monto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class "col-md-6">
                                <div class="form-group">
                                    <label for="fechaProgramada">Fecha Programada</label>
                                    <input type="date" 
                                           name="fechaProgramada" 
                                           id="fechaProgramada" 
                                           class="form-control @error('fechaProgramada') is-invalid @enderror" 
                                           value="{{ old('fechaProgramada', $solicitud->fechaProgramada) }}">
                                    @error('fechaProgramada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn text-white px-4" style="background-color: #5cb85c;">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('trabajador.solicitudes.cancelar') }}" class="btn btn-secondary px-4">
                                <i class="fas fa-ban me-1"></i> Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection