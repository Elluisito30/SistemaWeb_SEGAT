
@extends('layout.plantillaGerente')
@section('titulo','Nuevo Trabajador')
@section('contenido')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">REGISTRAR NUEVO TRABAJADOR</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>            
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('trabajador.store')}}">
                @csrf
  
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" 
                           class="form-control @error('nombres') is-invalid @enderror" 
                           id="nombres" 
                           name="nombres" 
                           value="{{ old('nombres') }}"
                           onkeypress="return soloLetras(event)"
                           maxlength="80">
                    @error('nombres')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" 
                           class="form-control @error('apellidos') is-invalid @enderror" 
                           id="apellidos" 
                           name="apellidos" 
                           value="{{ old('apellidos') }}"
                           onkeypress="return soloLetras(event)"
                           maxlength="80">
                    @error('apellidos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" 
                           class="form-control @error('edad') is-invalid @enderror" 
                           id="edad" 
                           name="edad" 
                           value="{{ old('edad') }}"
                           min="18" 
                           max="100">
                    @error('edad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           maxlength="100">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Sexo</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('sexo') is-invalid @enderror" 
                               type="radio" 
                               name="sexo" 
                               id="masculino" 
                               value="Masculino" 
                               {{ old('sexo') == 'Masculino' ? 'checked' : '' }}>
                        <label class="form-check-label" for="masculino">
                            <i class="fas fa-mars text-primary"></i> Masculino
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('sexo') is-invalid @enderror" 
                               type="radio" 
                               name="sexo" 
                               id="femenino" 
                               value="Femenino" 
                               {{ old('sexo') == 'Femenino' ? 'checked' : '' }}>
                        <label class="form-check-label" for="femenino">
                            <i class="fas fa-venus text-danger"></i> Femenino
                        </label>
                    </div>
                    @error('sexo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Estado Civil</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('estado_civil') is-invalid @enderror" 
                               type="radio" 
                               name="estado_civil" 
                               id="soltero" 
                               value="Soltero" 
                               {{ old('estado_civil') == 'Soltero' ? 'checked' : '' }}>
                        <label class="form-check-label" for="soltero">Soltero</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('estado_civil') is-invalid @enderror" 
                               type="radio" 
                               name="estado_civil" 
                               id="casado" 
                               value="Casado" 
                               {{ old('estado_civil') == 'Casado' ? 'checked' : '' }}>
                        <label class="form-check-label" for="casado">Casado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('estado_civil') is-invalid @enderror" 
                               type="radio" 
                               name="estado_civil" 
                               id="divorciado" 
                               value="Divorciado" 
                               {{ old('estado_civil') == 'Divorciado' ? 'checked' : '' }}>
                        <label class="form-check-label" for="divorciado">Divorciado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('estado_civil') is-invalid @enderror" 
                               type="radio" 
                               name="estado_civil" 
                               id="viudo" 
                               value="Viudo" 
                               {{ old('estado_civil') == 'Viudo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="viudo">Viudo</label>
                    </div>
                    @error('estado_civil')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar
                </button>
                <a href="{{ route('trabajador.index')}}" class="btn btn-danger">
                    <i class="fas fa-ban"></i> Cancelar
                </a>
            </form>
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