@extends('layout.plantilla')
@section('titulo','Nueva Infracción')

@section('estilos')
<style>
    /* Mejorar visualización de los selects */
    select.form-control {
        width: 100%;
        white-space: normal;
        height: auto;
        min-height: 38px;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    }
    
    select.form-control option {
        white-space: normal;
        padding: 5px;
    }
</style>
@endsection

@section('contenido')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">REGISTRAR NUEVA INFRACCIÓN AMBIENTAL</h3>

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
            <form method="POST" action="{{ route('infraccion.store')}}" enctype="multipart/form-data">
                @csrf

                <!-- SECCIÓN 1: Selección de Contribuyente -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5>1. DATOS DEL CONTRIBUYENTE</h5>
                    </div>
                    <div class="card-body">
                        
                        <!-- Opción: Contribuyente Existente o Nuevo -->
                        <div class="form-group">
                            <label>Tipo de Contribuyente</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="es_nuevo_contribuyente" 
                                       id="existente" value="0" 
                                       {{ old('es_nuevo_contribuyente', '0') == '0' ? 'checked' : '' }}
                                       onchange="toggleContribuyente()">
                                <label class="form-check-label" for="existente">Seleccionar Existente</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="es_nuevo_contribuyente" 
                                       id="nuevo" value="1" 
                                       {{ old('es_nuevo_contribuyente') == '1' ? 'checked' : '' }}
                                       onchange="toggleContribuyente()">
                                <label class="form-check-label" for="nuevo">Crear Nuevo</label>
                            </div>
                        </div>

                        <!-- Sección: Contribuyente Existente -->
                        <div id="seccion-existente">
                            <div class="form-group">
                                <label for="contribuyente_id">Seleccione Contribuyente</label>
                                <select class="form-control @error('contribuyente_id') is-invalid @enderror" 
                                        id="contribuyente_id" name="contribuyente_id">
                                    <option value="">Seleccione contribuyente...</option>
                                    @foreach($contribuyentes as $contrib)
                                        <option value="{{ $contrib->id_contribuyente }}" 
                                                {{ old('contribuyente_id') == $contrib->id_contribuyente ? 'selected' : '' }}>
                                            {{ $contrib->tipoDocumento->descripcionTipoD ?? 'N/A' }}: 
                                            {{ $contrib->numDocumento }} 
                                            - {{ $contrib->tipoContribuyente == 'N' ? 'Natural' : 'Jurídico' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('contribuyente_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Sección: Nuevo Contribuyente -->
                        <div id="seccion-nuevo" style="display: none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_tipoDocumento">Tipo de Documento</label>
                                        <select class="form-control @error('id_tipoDocumento') is-invalid @enderror" 
                                                id="id_tipoDocumento" name="id_tipoDocumento">
                                            <option value="">Seleccione tipo...</option>
                                            @foreach($tiposDocumento as $tipoDoc)
                                                <option value="{{ $tipoDoc->id_TipoDocumento }}" 
                                                        {{ old('id_tipoDocumento') == $tipoDoc->id_TipoDocumento ? 'selected' : '' }}>
                                                    {{ $tipoDoc->descripcionTipoD }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_tipoDocumento')
                                            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="numDocumento">Número de Documento</label>
                                        <input type="text" 
                                               class="form-control @error('numDocumento') is-invalid @enderror" 
                                               id="numDocumento" name="numDocumento" 
                                               value="{{ old('numDocumento') }}"
                                               maxlength="20">
                                        @error('numDocumento')
                                            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipoContribuyente">Tipo Contribuyente</label>
                                        <select class="form-control @error('tipoContribuyente') is-invalid @enderror" 
                                                id="tipoContribuyente" name="tipoContribuyente">
                                            <option value="">Seleccione...</option>
                                            <option value="N" {{ old('tipoContribuyente') == 'N' ? 'selected' : '' }}>
                                                Natural
                                            </option>
                                            <option value="J" {{ old('tipoContribuyente') == 'J' ? 'selected' : '' }}>
                                                Jurídico
                                            </option>
                                        </select>
                                        @error('tipoContribuyente')
                                            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Género</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('genero') is-invalid @enderror" 
                                                   type="radio" name="genero" id="masculino" value="Masculino" 
                                                   {{ old('genero') == 'Masculino' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="masculino">Masculino</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('genero') is-invalid @enderror" 
                                                   type="radio" name="genero" id="femenino" value="Femenino" 
                                                   {{ old('genero') == 'Femenino' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="femenino">Femenino</label>
                                        </div>
                                        @error('genero')
                                            <span class="invalid-feedback d-block" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="text" 
                                               class="form-control @error('telefono') is-invalid @enderror" 
                                               id="telefono" name="telefono" 
                                               value="{{ old('telefono') }}"
                                               maxlength="7">
                                        @error('telefono')
                                            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="celula">Celular</label>
                                        <input type="text" 
                                               class="form-control @error('celula') is-invalid @enderror" 
                                               id="celula" name="celula" 
                                               value="{{ old('celula') }}"
                                               maxlength="9">
                                        @error('celula')
                                            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </div>

                            <!-- Datos de Domicilio -->
                            <hr>
                            <h6 class="text-secondary">Domicilio</h6>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="direccionDomi">Dirección</label>
                                        <input type="text" 
                                               class="form-control @error('direccionDomi') is-invalid @enderror" 
                                               id="direccionDomi" name="direccionDomi" 
                                               value="{{ old('direccionDomi') }}"
                                               maxlength="30">
                                        @error('direccionDomi')
                                            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipoDomi">Tipo</label>
                                        <input type="text" 
                                               class="form-control @error('tipoDomi') is-invalid @enderror" 
                                               id="tipoDomi" name="tipoDomi" 
                                               value="{{ old('tipoDomi') }}"
                                               maxlength="1"
                                               placeholder="Ej: C (Casa), D (Depto)">
                                        @error('tipoDomi')
                                            <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_distrito">Distrito</label>
                                <select class="form-control @error('id_distrito') is-invalid @enderror" 
                                        id="id_distrito" name="id_distrito">
                                    <option value="">Seleccione distrito...</option>
                                    @foreach($distritos as $distrito)
                                        <option value="{{ $distrito->id_distrito }}" 
                                                {{ old('id_distrito') == $distrito->id_distrito ? 'selected' : '' }}>
                                            {{ $distrito->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_distrito')
                                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SECCIÓN 2: Datos de la Infracción -->
                <div class="card mb-3">
                    <div class="card-header bg-warning">
                        <h5>2. DATOS DE LA INFRACCIÓN</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lugarOcurrencia">Lugar de Ocurrencia</label>
                                    <input type="text" 
                                           class="form-control @error('lugarOcurrencia') is-invalid @enderror" 
                                           id="lugarOcurrencia" name="lugarOcurrencia" 
                                           value="{{ old('lugarOcurrencia') }}"
                                           maxlength="50">
                                    @error('lugarOcurrencia')
                                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fechaHora">Fecha y Hora de la Infracción</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('fechaHora') is-invalid @enderror" 
                                           id="fechaHora" name="fechaHora" 
                                           value="{{ old('fechaHora') }}">
                                    @error('fechaHora')
                                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipoInfraccion">Tipo de Infracción</label>
                            <select class="form-control @error('tipoInfraccion') is-invalid @enderror" 
                                    id="tipoInfraccion" name="tipoInfraccion">
                                <option value="">Seleccione tipo de infracción...</option>
                                @foreach($tiposInfraccion as $tipo)
                                    <option value="{{ $tipo->tipoInfraccion }}" 
                                            {{ old('tipoInfraccion') == $tipo->tipoInfraccion ? 'selected' : '' }}>
                                        {{ $tipo->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipoInfraccion')
                                <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="montoMulta">Monto de la Multa (S/)</label>
                                    <input type="number" 
                                           class="form-control @error('montoMulta') is-invalid @enderror" 
                                           id="montoMulta" name="montoMulta" 
                                           step="0.01" min="0"
                                           value="{{ old('montoMulta') }}">
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Se aplicará 50% de recargo a reincidentes automáticamente
                                    </small>
                                    @error('montoMulta')
                                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fechaLimitePago">Fecha Límite de Pago</label>
                                    <input type="date" 
                                           class="form-control @error('fechaLimitePago') is-invalid @enderror" 
                                           id="fechaLimitePago" name="fechaLimitePago" 
                                           value="{{ old('fechaLimitePago') }}">
                                    @error('fechaLimitePago')
                                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estadoPago">Estado de Pago</label>
                                    <select class="form-control @error('estadoPago') is-invalid @enderror" 
                                            id="estadoPago" name="estadoPago">
                                        <option value="">Seleccione estado...</option>
                                        <option value="Pendiente" {{ old('estadoPago') == 'Pendiente' ? 'selected' : '' }}>
                                            Pendiente
                                        </option>
                                        <option value="Pagado" {{ old('estadoPago') == 'Pagado' ? 'selected' : '' }}>
                                            Pagado
                                        </option>
                                        <option value="Vencido" {{ old('estadoPago') == 'Vencido' ? 'selected' : '' }}>
                                            Vencido
                                        </option>
                                    </select>
                                    @error('estadoPago')
                                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="documentoAdjunto">Documento Adjunto (PDF, JPG, PNG - Máx 2MB)</label>
                            <input type="file" 
                                   class="form-control-file @error('documentoAdjunto') is-invalid @enderror" 
                                   id="documentoAdjunto" name="documentoAdjunto"
                                   accept=".pdf,.jpg,.jpeg,.png">
                            @error('documentoAdjunto')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar Infracción
                </button>
                <a href="{{ route('infraccion.index')}}" class="btn btn-danger">
                    <i class="fas fa-ban"></i> Cancelar
                </a>
            </form>
        </div>
    </div>

    <script>
    function toggleContribuyente() {
        const esNuevo = document.getElementById('nuevo').checked;
        const seccionExistente = document.getElementById('seccion-existente');
        const seccionNuevo = document.getElementById('seccion-nuevo');
        
        if (esNuevo) {
            seccionExistente.style.display = 'none';
            seccionNuevo.style.display = 'block';
            document.getElementById('contribuyente_id').value = ''; // Limpiar select
        } else {
            seccionExistente.style.display = 'block';
            seccionNuevo.style.display = 'none';
        }
    }

    // Ejecutar al cargar la página para mantener estado si hay errores de validación
    document.addEventListener('DOMContentLoaded', function() {
        toggleContribuyente();
    });
    </script>

@endsection