@extends('layout.plantillaCiudadano')
@section('titulo','Reportar Infracción')
@section('contenido')

<div class="card">
  <div class="card-header">
    <h3 class="card-title">REGISTRAR INFRACCIÓN</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="card-body">
    
    {{-- Mensaje de éxito --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    {{-- Mensaje de error --}}
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    {{-- Errores de validación --}}
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('ciudadano.infracciones.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- Sección: Datos del Infractor --}}
      <div class="card mb-3">
        <div class="card-header bg-warning">
          <h5 class="mb-0"><i class="fas fa-user-times"></i> Datos del Infractor</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="email_infractor">Correo Electrónico <span class="text-danger">*</span></label>
                <input type="email" 
                       class="form-control @error('email_infractor') is-invalid @enderror" 
                       id="email_infractor" 
                       name="email_infractor" 
                       value="{{ old('email_infractor') }}"
                       required
                       placeholder="ejemplo@correo.com">
                @error('email_infractor')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="numDocumento_infractor">N° de DNI <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('numDocumento_infractor') is-invalid @enderror" 
                       id="numDocumento_infractor" 
                       name="numDocumento_infractor" 
                       value="{{ old('numDocumento_infractor') }}"
                       required
                       maxlength="8"
                       pattern="[0-9]{8}"
                       placeholder="12345678">
                @error('numDocumento_infractor')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="form-text text-muted">Ingrese 8 dígitos</small>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombres_infractor">Nombres (Opcional)</label>
                <input type="text" 
                       class="form-control @error('nombres_infractor') is-invalid @enderror" 
                       id="nombres_infractor" 
                       name="nombres_infractor" 
                       value="{{ old('nombres_infractor') }}"
                       maxlength="80"
                       placeholder="Nombres del infractor">
                @error('nombres_infractor')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="apellidos_infractor">Apellidos (Opcional)</label>
                <input type="text" 
                       class="form-control @error('apellidos_infractor') is-invalid @enderror" 
                       id="apellidos_infractor" 
                       name="apellidos_infractor" 
                       value="{{ old('apellidos_infractor') }}"
                       maxlength="80"
                       placeholder="Apellidos del infractor">
                @error('apellidos_infractor')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="telefono_infractor">Teléfono (Opcional)</label>
                <input type="text" 
                       class="form-control @error('telefono_infractor') is-invalid @enderror" 
                       id="telefono_infractor" 
                       name="telefono_infractor" 
                       value="{{ old('telefono_infractor') }}"
                       maxlength="20"
                       placeholder="987654321">
                @error('telefono_infractor')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Sección: Información de la Infracción --}}
      <div class="card mb-3">
        <div class="card-header bg-danger">
          <h5 class="mb-0"><i class="fas fa-exclamation-circle"></i> Información de la Infracción</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipoInfraccion">Tipo de Infracción <span class="text-danger">*</span></label>
                <select class="form-control @error('tipoInfraccion') is-invalid @enderror" 
                        id="tipoInfraccion" 
                        name="tipoInfraccion" 
                        required>
                  <option value="">-- Seleccione --</option>
                  @foreach($tiposInfraccion as $tipo)
                    <option value="{{ $tipo->tipoInfraccion }}" {{ old('tipoInfraccion') == $tipo->tipoInfraccion ? 'selected' : '' }}>
                      {{ $tipo->descripcion }}
                    </option>
                  @endforeach
                </select>
                @error('tipoInfraccion')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="lugarOcurrencia">Lugar de Ocurrencia <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('lugarOcurrencia') is-invalid @enderror" 
                       id="lugarOcurrencia" 
                       name="lugarOcurrencia" 
                       value="{{ old('lugarOcurrencia') }}"
                       required
                       maxlength="50"
                       placeholder="Ej: Av. Principal cdra. 5">
                @error('lugarOcurrencia')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="descripcion">Descripción / Observaciones (Opcional)</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                          id="descripcion" 
                          name="descripcion" 
                          rows="4"
                          maxlength="500"
                          placeholder="Describa los detalles de la infracción...">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="form-text text-muted">Máximo 500 caracteres</small>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="documentoAdjunto">Foto de Evidencia (Opcional)</label>
                <div class="custom-file">
                  <input type="file" 
                         class="custom-file-input @error('documentoAdjunto') is-invalid @enderror" 
                         id="documentoAdjunto" 
                         name="documentoAdjunto"
                         accept="image/jpeg,image/png,image/jpg">
                  <label class="custom-file-label" for="documentoAdjunto">Seleccionar archivo...</label>
                </div>
                @error('documentoAdjunto')
                  <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
                <small class="form-text text-muted">Formatos: JPG, JPEG, PNG. Tamaño máximo: 5MB</small>
              </div>
            </div>
          </div>

          <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle"></i>
            <strong>Nota:</strong> La fecha y hora de la infracción se registrarán automáticamente al momento de enviar este formulario.
          </div>
        </div>
      </div>

      {{-- Botones --}}
      <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Reportar Infracción
          </button>
          <a href="{{ route('ciudadano.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancelar
          </a>
        </div>
      </div>

    </form>
  </div>
</div>

@endsection

@section('script')
<script>
  // Script para mostrar el nombre del archivo seleccionado
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccionar archivo...';
    const label = e.target.nextElementSibling;
    label.textContent = fileName;
  });

  // Auto-hide de mensajes de éxito/error
  setTimeout(function(){
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);
</script>
@endsection
