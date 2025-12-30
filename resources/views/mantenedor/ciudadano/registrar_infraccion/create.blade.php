@extends('layout.plantillaCiudadano')
@section('titulo', 'Reportar Infracción')
@section('contenido')

<div class="container-fluid mt-3 px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #2d5f3f;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-exclamation-triangle me-2"></i> REGISTRAR INFRACCIÓN
                    </h5>
                </div>

                <div class="card-body">
                    {{-- Mensajes de sesión --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

                    <form action="{{ route('ciudadano.infracciones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Sección: Datos del Infractor --}}
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="card-header" style="background-color: #e9ecef;">
                                <h6 class="mb-0 text-dark">
                                    <i class="fas fa-user-times text-danger me-2"></i> <strong>Datos del Infractor</strong>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_infractor">Correo Electrónico: <span class="text-danger">*</span></label>
                                            <input type="email"
                                                   class="form-control @error('email_infractor') is-invalid @enderror"
                                                   id="email_infractor"
                                                   name="email_infractor"
                                                   value="{{ old('email_infractor') }}"
                                                   placeholder="ejemplo@correo.com">
                                            @error('email_infractor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="numDocumento_infractor">N° de DNI: <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('numDocumento_infractor') is-invalid @enderror"
                                                   id="numDocumento_infractor"
                                                   name="numDocumento_infractor"
                                                   value="{{ old('numDocumento_infractor') }}"
                                                   maxlength="8"
                                                   pattern="[0-9]{8}"
                                                   placeholder="Ingrese 8 dígitos...">
                                            @error('numDocumento_infractor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombres_infractor">Nombres (Opcional):</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="nombres_infractor"
                                                   name="nombres_infractor"
                                                   value="{{ old('nombres_infractor') }}"
                                                   maxlength="80"
                                                   placeholder="Nombres del infractor">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apellidos_infractor">Apellidos (Opcional):</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="apellidos_infractor"
                                                   name="apellidos_infractor"
                                                   value="{{ old('apellidos_infractor') }}"
                                                   maxlength="80"
                                                   placeholder="Apellidos del infractor">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono_infractor">Teléfono (Opcional):</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="telefono_infractor"
                                                   name="telefono_infractor"
                                                   value="{{ old('telefono_infractor') }}"
                                                   maxlength="20"
                                                   placeholder="987654321">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Información de la Infracción --}}
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="card-header" style="background-color: #e9ecef;">
                                <h6 class="mb-0 text-dark">
                                    <i class="fas fa-exclamation-circle text-warning me-2"></i> <strong>Información de la Infracción</strong>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipoInfraccion">Tipo de Infracción: <span class="text-danger">*</span></label>
                                            <select class="form-control select-wide @error('tipoInfraccion') is-invalid @enderror"
                                                    id="tipoInfraccion"
                                                    name="tipoInfraccion">
                                                <option value="" @if(!$errors->has('tipoInfraccion')) selected @endif>
                                                    -- Seleccione --
                                                </option>
                                                @foreach($tiposInfraccion as $tipo)
                                                    <option value="{{ $tipo->tipoInfraccion }}" @if($errors->has('tipoInfraccion') && (string) old('tipoInfraccion') === (string) $tipo->tipoInfraccion) selected @endif>
                                                        {{ $tipo->descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tipoInfraccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lugarOcurrencia">Lugar de Ocurrencia: <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('lugarOcurrencia') is-invalid @enderror"
                                                   id="lugarOcurrencia"
                                                   name="lugarOcurrencia"
                                                   value="{{ old('lugarOcurrencia') }}"
                                                   maxlength="50"
                                                   placeholder="Ej: Av. Principal cdra. 5">
                                            @error('lugarOcurrencia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripción / Observaciones (Opcional):</label>
                                            <textarea class="form-control"
                                                      id="descripcion"
                                                      name="descripcion"
                                                      rows="3"
                                                      maxlength="500"
                                                      placeholder="Describa los detalles de la infracción...">{{ old('descripcion') }}</textarea>
                                            <small class="form-text text-muted">Máximo 500 caracteres...</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="documentoAdjunto">Foto de Evidencia: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="file"
                                                       class="form-control @error('documentoAdjunto') is-invalid @enderror"
                                                       id="documentoAdjunto"
                                                       name="documentoAdjunto"
                                                       accept="image/jpeg,image/png,image/jpg">
                                            </div>
                                            @error('documentoAdjunto')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Formatos: JPG, PNG. Máx. 5 MB...</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-light border border-info mt-4 mb-0">
                                    <i class="fas fa-info-circle text-info me-2"></i>
                                    <strong>Nota:</strong> La fecha y hora de la infracción se registrarán automáticamente al momento de enviar este formulario.
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn text-white px-4" style="background-color: #5cb85c;">
                                <i class="fas fa-paper-plane me-1"></i> Reportar Infracción
                            </button>
                            <a href="{{ route('ciudadano.dashboard') }}" class="btn btn-secondary px-4">
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

@section('script')
<script>

    // Mostrar nombre del archivo seleccionado
    document.getElementById('documentoAdjunto')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Seleccionar archivo...';
        e.target.nextElementSibling?.classList.remove('text-muted');
        e.target.nextElementSibling?.textContent = fileName;
    });

    // Auto-ocultar mensajes
    setTimeout(() => {
        document.querySelectorAll('.alert-dismissible').forEach(el => {
            const alert = bootstrap.Alert.getOrCreateInstance(el);
            alert.close();
        });
    }, 5000);
</script>
@endsection