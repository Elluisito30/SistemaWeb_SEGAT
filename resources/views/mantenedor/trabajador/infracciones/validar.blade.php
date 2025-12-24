@extends('layout.plantillaTrabajador')
@section('titulo', 'Validar Infracción')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">
    
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-header bg-white border-0 pt-4 pb-3">
        <h4 class="font-weight-bold mb-0">
          <i class="fas fa-check-circle mr-2" style="color: #16a34a;"></i>
          Validar Infracción #{{ $infraccion->id_infraccion }}
        </h4>
      </div>

      <div class="card-body p-4">
        
        <!-- Información de la infracción -->
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card border-0" style="background: #fef3c7;">
              <div class="card-body">
                <h6 class="font-weight-bold mb-3">
                  <i class="fas fa-exclamation-triangle mr-2" style="color: #f59e0b;"></i>
                  Detalles de la Infracción
                </h6>
                <p class="mb-2">
                  <strong>Tipo:</strong> 
                  {{ $infraccion->detalleInfraccion->tipoInfraccion->descripcion ?? 'N/A' }}
                </p>
                <p class="mb-2">
                  <strong>Lugar de Ocurrencia:</strong><br>
                  {{ $infraccion->detalleInfraccion->lugarOcurrencia ?? 'N/A' }}
                </p>
                <p class="mb-0">
                  <strong>Fecha y Hora:</strong><br>
                  {{ date('d/m/Y H:i', strtotime($infraccion->detalleInfraccion->fechaHora)) }}
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card border-0" style="background: #fee2e2;">
              <div class="card-body">
                <h6 class="font-weight-bold mb-3">
                  <i class="fas fa-user mr-2" style="color: #dc2626;"></i>
                  Datos del Infractor
                </h6>
                <p class="mb-2">
                  <strong>Documento:</strong> 
                  {{ $infraccion->detalleInfraccion->contribuyente->numDocumento ?? 'N/A' }}
                </p>
                <p class="mb-2">
                  <strong>Email:</strong> 
                  {{ $infraccion->detalleInfraccion->contribuyente->email ?? 'N/A' }}
                </p>
                <p class="mb-0">
                  <strong>Teléfono:</strong> 
                  {{ $infraccion->detalleInfraccion->contribuyente->telefono ?? 'N/A' }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Evidencia adjunta -->
        @if($infraccion->documentoAdjunto)
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-white">
                <h6 class="font-weight-bold mb-0">
                  <i class="fas fa-image mr-2" style="color: #16a34a;"></i>
                  Evidencia Fotográfica
                </h6>
              </div>
              <div class="card-body text-center">
                <img src="{{ asset('storage/infracciones/'.$infraccion->documentoAdjunto) }}" 
                     alt="Evidencia" 
                     class="img-fluid"
                     style="max-height: 400px; border-radius: 10px;">
              </div>
            </div>
          </div>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Formulario de validación -->
        <form method="POST" action="{{ route('trabajador.infracciones.storeValidacion', $infraccion->id_infraccion) }}">
          @csrf

          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
              <h6 class="font-weight-bold mb-0">
                <i class="fas fa-gavel mr-2" style="color: #16a34a;"></i>
                Asignar Multa
              </h6>
            </div>
            <div class="card-body">
              
              <div class="row">
                <!-- Monto de la multa -->
                <div class="col-md-4 mb-3">
                  <label class="font-weight-bold">Monto de la Multa (S/.) <span class="text-danger">*</span></label>
                  <input type="number" 
                         name="montoMulta" 
                         class="form-control" 
                         step="0.01"
                         min="0"
                         max="99999.99"
                         value="{{ old('montoMulta', $infraccion->montoMulta) }}"
                         placeholder="0.00"
                         required>
                  <small class="text-muted">Ingrese el monto de la sanción</small>
                </div>

                <!-- Fecha límite de pago -->
                <div class="col-md-4 mb-3">
                  <label class="font-weight-bold">Fecha Límite de Pago <span class="text-danger">*</span></label>
                  <input type="date" 
                         name="fechaLimitePago" 
                         class="form-control" 
                         value="{{ old('fechaLimitePago', $infraccion->fechaLimitePago) }}"
                         min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                         required>
                  <small class="text-muted">Fecha máxima para pagar</small>
                </div>

                <!-- Estado de pago -->
                <div class="col-md-4 mb-3">
                  <label class="font-weight-bold">Estado de Pago <span class="text-danger">*</span></label>
                  <select name="estadoPago" class="form-control" required>
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
                </div>
              </div>

            </div>
          </div>

          <!-- Información importante -->
          <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Importante:</strong> Al validar esta infracción, se registrará tu nombre como trabajador responsable 
            y se notificará al infractor sobre la multa asignada.
          </div>

          <!-- Botones de acción -->
          <div class="d-flex justify-content-between">
            <a href="{{ route('trabajador.infracciones.index') }}" 
               class="btn btn-secondary">
              <i class="fas fa-arrow-left mr-2"></i>Regresar
            </a>
            <button type="submit" class="btn btn-success btn-lg">
              <i class="fas fa-check mr-2"></i>Validar Infracción y Asignar Multa
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>
</section>

@endsection