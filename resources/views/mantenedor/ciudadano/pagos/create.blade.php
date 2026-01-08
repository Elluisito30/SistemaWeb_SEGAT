@extends('layout.plantillaCiudadano')
@section('titulo', 'Registrar Pago')
@section('contenido')

<div class="container-fluid mt-3 px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background-color: #28a745;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-credit-card me-2"></i> FORMULARIO DE PAGO - INFRACCIÓN #{{ $infraccion->id_infraccion }}
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
                                    <p class="mb-2"><strong>Lugar:</strong> {{ $infraccion->detalleInfraccion->lugarOcurrencia ?? 'N/A' }}</p>
                                    <p class="mb-0"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($infraccion->detalleInfraccion->fechaHora)->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0" style="background-color: #ffebee;">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-dark">
                                        <i class="fas fa-dollar-sign text-danger me-2"></i>
                                        <strong>Información de la Multa</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Monto a Pagar:</strong> <span class="text-danger fs-4">S/ {{ number_format($infraccion->montoMulta, 2) }}</span></p>
                                    <p class="mb-2"><strong>Fecha Límite:</strong> {{ \Carbon\Carbon::parse($infraccion->fechaLimitePago)->format('d/m/Y') }}</p>
                                    <p class="mb-0"><strong>Estado:</strong> <span class="badge bg-warning text-dark">{{ $infraccion->estadoPago }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
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

                    <!-- Formulario de pago -->
                    <form method="POST" action="{{ route('ciudadano.pagos.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="id_infraccion" value="{{ $infraccion->id_infraccion }}">

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 text-dark">
                                    <i class="fas fa-file-invoice-dollar text-success me-2"></i>
                                    <strong>Datos del Pago</strong>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Monto pagado -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Monto Pagado (S/.) <span class="text-danger">*</span></label>
                                        <input type="number" 
                                               name="montoPagado" 
                                               class="form-control @error('montoPagado') is-invalid @enderror" 
                                               step="0.01"
                                               min="0.01"
                                               value="{{ old('montoPagado', $infraccion->montoMulta) }}"
                                               readonly
                                               required>
                                        <small class="form-text text-muted">Monto de la multa</small>
                                        @error('montoPagado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Fecha de pago -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Fecha de Pago <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               name="fechaPago" 
                                               class="form-control @error('fechaPago') is-invalid @enderror" 
                                               value="{{ old('fechaPago', date('Y-m-d')) }}"
                                               max="{{ date('Y-m-d') }}"
                                               required>
                                        <small class="form-text text-muted">Fecha en que realizó el pago</small>
                                        @error('fechaPago')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Método de pago -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Método de Pago <span class="text-danger">*</span></label>
                                        <select name="metodoPago" class="form-control select-wide @error('metodoPago') is-invalid @enderror" required>
                                            <option value="">Seleccione...</option>
                                            <option value="Efectivo" {{ old('metodoPago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                            <option value="Transferencia" {{ old('metodoPago') == 'Transferencia' ? 'selected' : '' }}>Transferencia Bancaria</option>
                                            <option value="Tarjeta" {{ old('metodoPago') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta de Débito/Crédito</option>
                                            <option value="Yape" {{ old('metodoPago') == 'Yape' ? 'selected' : '' }}>Yape</option>
                                            <option value="Plin" {{ old('metodoPago') == 'Plin' ? 'selected' : '' }}>Plin</option>
                                        </select>
                                        @error('metodoPago')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Número de operación -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Número de Operación</label>
                                        <input type="text" 
                                               name="numeroOperacion" 
                                               class="form-control @error('numeroOperacion') is-invalid @enderror" 
                                               value="{{ old('numeroOperacion') }}"
                                               placeholder="Ej: 0527210"
                                               maxlength="50">
                                        <small class="form-text text-muted">N° de operación bancaria (opcional)</small>
                                        @error('numeroOperacion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Entidad financiera -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Entidad Financiera</label>
                                        <input type="text" 
                                               name="entidadFinanciera" 
                                               class="form-control @error('entidadFinanciera') is-invalid @enderror" 
                                               value="{{ old('entidadFinanciera') }}"
                                               placeholder="Ej: INTERBANK, BCP, BBVA"
                                               maxlength="100">
                                        <small class="form-text text-muted">Banco o entidad (opcional)</small>
                                        @error('entidadFinanciera')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Comprobante adjunto -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Comprobante de Pago (Voucher)</label>
                                        <input type="file" 
                                               name="comprobanteAdjunto" 
                                               class="form-control select-wide @error('comprobanteAdjunto') is-invalid @enderror"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="form-text text-muted">Formatos: PDF, JPG, PNG. Tamaño máximo: 5MB (opcional)</small>
                                        @error('comprobanteAdjunto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Observaciones -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Observaciones</label>
                                        <textarea name="observaciones" 
                                                  class="form-control @error('observaciones') is-invalid @enderror" 
                                                  rows="3"
                                                  maxlength="500"
                                                  placeholder="Ingrese cualquier comentario adicional (opcional)">{{ old('observaciones') }}</textarea>
                                        <small class="form-text text-muted">Información adicional sobre el pago</small>
                                        @error('observaciones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información importante -->
                        <div class="alert alert-warning shadow-sm mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Importante:</strong> Al confirmar el pago, la multa será marcada como pagada automáticamente. 
                            Asegúrese de que los datos sean correctos antes de continuar.
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between gap-3">
                            <a href="{{ route('ciudadano.pagos.index') }}" 
                               class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-check me-2"></i> Confirmar Pago
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
