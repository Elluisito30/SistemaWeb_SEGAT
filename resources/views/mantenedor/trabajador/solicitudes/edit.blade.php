@extends('layout.plantillaTrabajador')
@section('titulo', 'Programar Solicitud')
@section('contenido')

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h3 class="mb-0"><i class="fas fa-calendar-alt mr-2"></i>Programar / Cambiar Estado de Solicitud</h3>
        </div>
        <div class="card-body">

            <!-- Información de la Solicitud -->
            <div class="alert alert-info">
                <h5>Información de la Solicitud N° {{ $solicitud->id_solicitud }}</h5>
                <p class="mb-1"><strong>Área Verde:</strong> {{ $solicitud->detalleSolicitud->areaVerde->nombre ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Contribuyente:</strong> {{ $solicitud->detalleSolicitud->contribuyente->nombres ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Servicio:</strong> {{ $solicitud->servicio->nombre ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Descripción:</strong> {{ $solicitud->descripcion }}</p>
                <p class="mb-1"><strong>Prioridad:</strong> 
                    <span class="badge badge-{{ $solicitud->prioridad == 'ALTA' ? 'danger' : ($solicitud->prioridad == 'MEDIA' ? 'warning' : 'info') }}">
                        {{ $solicitud->prioridad }}
                    </span>
                </p>
                <p class="mb-0"><strong>Fecha Tentativa:</strong> {{ \Carbon\Carbon::parse($solicitud->fechaTentativaEjecucion)->format('d/m/Y') }}</p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('trabajador.solicitudes.update', $solicitud->id_solicitud) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Estado <span class="text-danger">*</span></label>
                            <select name="estado" class="form-control @error('estado') is-invalid @enderror" required>
                                <option value="registrada" {{ $solicitud->estado == 'registrada' ? 'selected' : '' }}>Registrada</option>
                                <option value="en atención" {{ $solicitud->estado == 'en atención' ? 'selected' : '' }}>En Atención</option>
                                <option value="atendida" {{ $solicitud->estado == 'atendida' ? 'selected' : '' }}>Atendida</option>
                                <option value="rechazada" {{ $solicitud->estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Al asignar monto y fecha, el estado cambia automáticamente a "En Atención"
                            </small>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="text-primary"><i class="fas fa-calendar-check"></i> Programación (Opcional)</h5>
                <p class="text-muted">Asigne monto y fecha para programar la solicitud</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Monto (S/)</label>
                            <input type="number" name="monto" step="0.01" min="0" max="99999.99" 
                                   class="form-control @error('monto') is-invalid @enderror" 
                                   value="{{ old('monto', $solicitud->monto) }}"
                                   placeholder="0.00">
                            @error('monto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha Programada</label>
                            <input type="date" name="fechaProgramada" 
                                   class="form-control @error('fechaProgramada') is-invalid @enderror" 
                                   value="{{ old('fechaProgramada', $solicitud->fechaProgramada) }}">
                            @error('fechaProgramada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('trabajador.solicitudes.cancelar') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
