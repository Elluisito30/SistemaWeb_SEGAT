@extends('layout.plantillaTrabajador')
@section('titulo', 'Validar Infracción')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <!-- Header verde -->
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #2d5f3f;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-check-circle me-2"></i> VALIDAR INFRACCIÓN N°{{ $infraccion->id_infraccion }}
                    </h5>
                </div>

                <div class="card-body p-4">

                    <!-- Información de la infracción -->
                    <div class="row mb-4 g-3">
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0" style="background-color: #fff8e1;">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-dark">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        <strong>Detalles de la Infracción</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Tipo:</strong> {{ $infraccion->detalleInfraccion->tipo->descripcion ?? 'N/A' }}</p>
                                    <p class="mb-2"><strong>Lugar de Ocurrencia:</strong> {{ $infraccion->detalleInfraccion->lugarOcurrencia ?? 'N/A' }}</p>
                                    <p class="mb-0"><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($infraccion->detalleInfraccion->fechaHora)->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0" style="background-color: #ffebee;">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-dark">
                                        <i class="fas fa-user text-danger me-2"></i>
                                        <strong>Datos del Infractor</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Documento:</strong> {{ $infraccion->detalleInfraccion->contribuyente->numDocumento ?? 'N/A' }}</p>
                                    <p class="mb-2"><strong>Email:</strong> {{ $infraccion->detalleInfraccion->contribuyente->email ?? 'N/A' }}</p>
                                    <p class="mb-0"><strong>Teléfono:</strong> {{ $infraccion->detalleInfraccion->contribuyente->telefono ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Evidencia adjunta -->
                    @if($infraccion->documentoAdjunto)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-dark">
                                        <i class="fas fa-image text-success me-2"></i>
                                        <strong>Evidencia Fotográfica</strong>
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/infracciones/'.$infraccion->documentoAdjunto) }}" 
                                         alt="Evidencia" 
                                         class="img-fluid rounded"
                                         style="max-height: 400px; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario de validación -->
                    <form method="POST" action="{{ route('trabajador.infracciones.storeValidacion', $infraccion->id_infraccion) }}">
                        @csrf

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 text-dark">
                                    <i class="fas fa-gavel text-success me-2"></i>
                                    <strong>Asignar Multa</strong>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Monto de la multa -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Monto de la multa (S/.) <span class="text-danger">*</span></label>
                                        <input type="number" 
                                               name="montoMulta" 
                                               class="form-control @error('montoMulta') is-invalid @enderror" 
                                               step="0.01"
                                               min="0"
                                               max="99999.99"
                                               value="{{ old('montoMulta', $infraccion->montoMulta) }}"
                                               placeholder="0.00"
                                               required>
                                        <small class="form-text text-muted">Ingrese el monto de la sanción...</small>
                                        @error('montoMulta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Fecha límite de pago -->
                                    <div class "col-md-4">
                                        <label class="form-label fw-bold">Fecha límite de pago <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               name="fechaLimitePago" 
                                               class="form-control @error('fechaLimitePago') is-invalid @enderror" 
                                               value="{{ old('fechaLimitePago', $infraccion->fechaLimitePago) }}"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               required>
                                        <small class="form-text text-muted">Coloque la fecha máxima a pagar...</small>
                                        @error('fechaLimitePago')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Estado de pago -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Estado de pago <span class="text-danger">*</span></label>
                                        <select name="estadoPago" class="form-control select-wide @error('estadoPago') is-invalid @enderror" required>
                                            <option value="Pendiente" {{ old('estadoPago', $infraccion->estadoPago) == 'Pendiente' ? 'selected' : '' }}>
                                                Pendiente
                                            </option>
                                            <option value="Pagada" {{ old('estadoPago', $infraccion->estadoPago) == 'Pagada' ? 'selected' : '' }}>
                                                Pagada
                                            </option>
                                            <option value="Vencida" {{ old('estadoPago', $infraccion->estadoPago) == 'Vencida' ? 'selected' : '' }}>
                                                Vencida
                                            </option>
                                        </select>
                                        @error('estadoPago')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información importante -->
                        <div class="alert alert-info shadow-sm mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Importante:</strong> Al validar esta infracción, se registrará tu nombre como trabajador responsable 
                            y se notificará al infractor sobre la multa asignada.
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between gap-3">
                            <a href="{{ route('trabajador.infracciones.index') }}" 
                               class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i> Regresar
                            </a>
                            <button type="submit" class="btn text-white px-4" style="background-color: #5cb85c;">
                                <i class="fas fa-check me-2"></i> Validar infracción y asignar multa
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection