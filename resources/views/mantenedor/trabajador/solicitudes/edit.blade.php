@extends('layout.plantillaTrabajador')
@section('titulo', 'Gestionar Solicitud')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">
    
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-header bg-white border-0 pt-4 pb-3">
        <h4 class="font-weight-bold mb-0">
          <i class="fas fa-edit mr-2" style="color: #16a34a;"></i>
          Gestionar Solicitud #{{ $solicitud->id_solicitud }}
        </h4>
      </div>

      <div class="card-body p-4">
        
        <!-- Información de la solicitud -->
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card border-0" style="background: #f0fdf4;">
              <div class="card-body">
                <h6 class="font-weight-bold mb-3">
                  <i class="fas fa-info-circle mr-2" style="color: #16a34a;"></i>
                  Información de la Solicitud
                </h6>
                <p class="mb-2">
                  <strong>Área Verde:</strong> 
                  {{ $solicitud->detalleSolicitud->areaVerde->nombre ?? 'N/A' }}
                </p>
                <p class="mb-2">
                  <strong>Servicio:</strong> 
                  {{ $solicitud->servicio->descripcion ?? 'N/A' }}
                </p>
                <p class="mb-2">
                  <strong>Prioridad:</strong> 
                  <span class="badge badge-{{ $solicitud->prioridad == 'ALTA' ? 'danger' : ($solicitud->prioridad == 'MEDIA' ? 'warning' : 'info') }}">
                    {{ $solicitud->prioridad }}
                  </span>
                </p>
                <p class="mb-2">
                  <strong>Descripción:</strong><br>
                  {{ $solicitud->descripcion }}
                </p>
                <p class="mb-0">
                  <strong>Fecha Tentativa:</strong> 
                  {{ date('d/m/Y', strtotime($solicitud->fechaTentativaEjecucion)) }}
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card border-0" style="background: #dcfce7;">
              <div class="card-body">
                <h6 class="font-weight-bold mb-3">
                  <i class="fas fa-user mr-2" style="color: #16a34a;"></i>
                  Datos del Solicitante
                </h6>
                <p class="mb-2">
                  <strong>Contribuyente:</strong> 
                  {{ $solicitud->detalleSolicitud->contribuyente->email ?? 'N/A' }}
                </p>
                <p class="mb-0">
                  <strong>Documento:</strong> 
                  {{ $solicitud->detalleSolicitud->contribuyente->numDocumento ?? 'N/A' }}
                </p>
              </div>
            </div>
          </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Formulario de gestión -->
        <form method="POST" action="{{ route('trabajador.solicitudes.update', $solicitud->id_solicitud) }}">
          @csrf
          @method('PUT')

          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
              <h6 class="font-weight-bold mb-0">
                <i class="fas fa-cogs mr-2" style="color: #16a34a;"></i>
                Gestión de Solicitud
              </h6>
            </div>
            <div class="card-body">
              
              <div class="row">
                <!-- Estado -->
                <div class="col-md-6 mb-3">
                  <label class="font-weight-bold">Estado <span class="text-danger">*</span></label>
                  <select name="estado" class="form-control" required>
                    <option value="">Seleccione estado</option>
                    <option value="registrada" {{ $solicitud->estado == 'registrada' ? 'selected' : '' }}>
                      Registrada
                    </option>
                    <option value="en atención" {{ $solicitud->estado == 'en atención' ? 'selected' : '' }}>
                      En Atención
                    </option>
                    <option value="atendida" {{ $solicitud->estado == 'atendida' ? 'selected' : '' }}>
                      Atendida
                    </option>
                    <option value="rechazado" {{ $solicitud->estado == 'rechazado' ? 'selected' : '' }}>
                      Rechazado
                    </option>
                  </select>
                </div>
              </div>

              <hr class="my-4">

              <h6 class="font-weight-bold mb-3">
                <i class="fas fa-calendar-check mr-2" style="color: #16a34a;"></i>
                Programación (Opcional)
              </h6>
              <p class="text-muted small mb-3">
                Al asignar monto y fecha, el estado cambiará automáticamente a "En Atención"
              </p>

              <div class="row">
                <!-- Monto -->
                <div class="col-md-6 mb-3">
                  <label class="font-weight-bold">Monto (S/.)</label>
                  <input type="number" 
                         name="monto" 
                         class="form-control" 
                         step="0.01"
                         min="0"
                         max="99999.99"
                         value="{{ old('monto', $solicitud->monto) }}"
                         placeholder="0.00">
                </div>

                <!-- Fecha Programada -->
                <div class="col-md-6 mb-3">
                  <label class="font-weight-bold">Fecha Programada</label>
                  <input type="date" 
                         name="fechaProgramada" 
                         class="form-control" 
                         value="{{ old('fechaProgramada', $solicitud->fechaProgramada) }}">
                </div>
              </div>

            </div>
          </div>

          <!-- Botones de acción -->
          <div class="d-flex justify-content-between">
            <a href="{{ route('trabajador.solicitudes.index') }}" 
               class="btn btn-secondary">
              <i class="fas fa-arrow-left mr-2"></i>Regresar
            </a>
            <button type="submit" class="btn btn-success">
              <i class="fas fa-save mr-2"></i>Guardar Cambios
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>
</section>

@endsection