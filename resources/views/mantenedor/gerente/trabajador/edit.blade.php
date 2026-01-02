@extends('layout.plantillaGerente')
@section('titulo', 'Editar Trabajador')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #198754;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-user-edit me-2"></i> EDITAR TRABAJADOR
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('trabajador.update', $trabajador->idtrabajador) }}">
                        @method('PUT')
                        @csrf

                        <!-- Código (solo lectura) -->
                        <div class="mb-3">
                            <label for="id" class="form-label fw-bold">Código</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="id" 
                                   name="id" 
                                   value="{{ $trabajador->idtrabajador }}" 
                                   disabled>
                        </div>

                        <!-- Nombres -->
                        <div class="mb-3">
                            <label for="nombres" class="form-label fw-bold">Nombres <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombres') is-invalid @enderror" 
                                   id="nombres" 
                                   name="nombres" 
                                   value="{{ old('nombres', $trabajador->nombres) }}"
                                   onkeypress="return soloLetras(event)"
                                   maxlength="80"
                                   placeholder="Ingrese nombres">
                            @error('nombres')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div class="mb-3">
                            <label for="apellidos" class="form-label fw-bold">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('apellidos') is-invalid @enderror" 
                                   id="apellidos" 
                                   name="apellidos" 
                                   value="{{ old('apellidos', $trabajador->apellidos) }}"
                                   onkeypress="return soloLetras(event)"
                                   maxlength="80"
                                   placeholder="Ingrese apellidos">
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Edad -->
                        <div class="mb-3">
                            <label for="edad" class="form-label fw-bold">Edad <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('edad') is-invalid @enderror" 
                                   id="edad" 
                                   name="edad" 
                                   value="{{ old('edad', $trabajador->edad) }}"
                                   min="18" 
                                   max="100"
                                   placeholder="Ingrese edad">
                            @error('edad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $trabajador->email) }}"
                                   maxlength="100"
                                   placeholder="ejemplo@correo.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña (opcional) -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Nueva Contraseña <span class="text-muted">(opcional)</span></label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   placeholder="Dejar en blanco para mantener la actual">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña (opcional) -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Confirmar Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   placeholder="Confirme la nueva contraseña">
                        </div>

                        <!-- Sexo -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sexo <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('sexo') is-invalid @enderror" 
                                           type="radio" 
                                           name="sexo" 
                                           id="masculino" 
                                           value="Masculino" 
                                           {{ old('sexo', $trabajador->sexo) == 'Masculino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="masculino">
                                        <i class="fas fa-mars text-primary me-1"></i> Masculino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('sexo') is-invalid @enderror" 
                                           type="radio" 
                                           name="sexo" 
                                           id="femenino" 
                                           value="Femenino" 
                                           {{ old('sexo', $trabajador->sexo) == 'Femenino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="femenino">
                                        <i class="fas fa-venus text-danger me-1"></i> Femenino
                                    </label>
                                </div>
                            </div>
                            @error('sexo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado Civil -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Estado Civil <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach(['Soltero', 'Casado', 'Divorciado', 'Viudo'] as $estado)
                                    <div class="form-check">
                                        <input class="form-check-input @error('estado_civil') is-invalid @enderror" 
                                               type="radio" 
                                               name="estado_civil" 
                                               id="{{ strtolower($estado) }}" 
                                               value="{{ $estado }}" 
                                               {{ old('estado_civil', $trabajador->estado_civil) == $estado ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ strtolower($estado) }}">
                                            {{ $estado }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('estado_civil')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn text-white px-4" style="background-color: #198754;">
                                <i class="fas fa-save me-1"></i> Actualizar
                            </button>
                            <a href="{{ route('trabajador.index') }}" class="btn btn-secondary px-4">
                                <i class="fas fa-ban me-1"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function soloLetras(e) {
    const char = String.fromCharCode(e.which);
    const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;
    if (!regex.test(char)) {
        e.preventDefault();
        return false;
    }
    return true;
}
</script>
@endsection