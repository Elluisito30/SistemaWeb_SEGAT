@extends('layout.plantilla')
@section('titulo','Editar Infracción')
@section('contenido')
    
    <div class="container"> 
        <h1>EDITAR INFRACCIÓN</h1> 
        
        <form method="POST" action="{{ route('infraccion.update', $infraccion->id_infraccion) }}" enctype="multipart/form-data"> 
            @method('put') 
            @csrf 
            
            <!-- Información del Contribuyente (Solo lectura) -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5>Datos del Contribuyente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label><strong>Tipo Documento:</strong></label>
                            <p>{{ $infraccion->detalleInfraccion->contribuyente->tipoDocumento->descripcionTipoD ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label><strong>Número Documento:</strong></label>
                            <p>{{ $infraccion->detalleInfraccion->contribuyente->numDocumento }}</p>
                        </div>
                        <div class="col-md-4">
                            <label><strong>Tipo:</strong></label>
                            <p>{{ $infraccion->detalleInfraccion->contribuyente->tipoContribuyente == 'N' ? 'Natural' : 'Jurídico' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label><strong>Email:</strong></label>
                            <p>{{ $infraccion->detalleInfraccion->contribuyente->email ?? 'Sin email' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Teléfono:</strong></label>
                            <p>{{ $infraccion->detalleInfraccion->contribuyente->celula ?? 'Sin teléfono' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos de la Infracción (Editables) -->
            <div class="card mb-3">
                <div class="card-header bg-warning">
                    <h5>Datos de la Infracción</h5>
                </div>
                <div class="card-body">
                    
                    <div class="form-group"> 
                        <label for="lugarOcurrencia">Lugar de Ocurrencia</label> 
                        <input type="text" 
                               class="form-control @error('lugarOcurrencia') is-invalid @enderror" 
                               id="lugarOcurrencia" 
                               name="lugarOcurrencia" 
                               value="{{ $infraccion->detalleInfraccion->lugarOcurrencia }}"
                               maxlength="50"> 
                        @error('lugarOcurrencia') 
                            <span class="invalid-feedback" role="alert"> 
                                <strong>{{ $message }}</strong> 
                            </span> 
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tipoInfraccion">Tipo de Infracción</label>
                        <select class="form-control @error('tipoInfraccion') is-invalid @enderror" 
                                id="tipoInfraccion" 
                                name="tipoInfraccion">
                            <option value="">Seleccione tipo de infracción...</option>
                            @foreach($tiposInfraccion as $tipo)
                                <option value="{{ $tipo->tipoInfraccion }}" 
                                        {{ $infraccion->detalleInfraccion->tipoInfraccion == $tipo->tipoInfraccion ? 'selected' : '' }}>
                                    {{ $tipo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipoInfraccion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <label for="montoMulta">Monto de la Multa (S/)</label> 
                                <input type="number" 
                                       class="form-control @error('montoMulta') is-invalid @enderror" 
                                       id="montoMulta" 
                                       name="montoMulta" 
                                       step="0.01"
                                       min="0"
                                       value="{{ $infraccion->montoMulta }}"> 
                                @error('montoMulta') 
                                    <span class="invalid-feedback" role="alert"> 
                                        <strong>{{ $message }}</strong> 
                                    </span> 
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group"> 
                                <label for="fechaLimitePago">Fecha Límite de Pago</label> 
                                <input type="date" 
                                       class="form-control @error('fechaLimitePago') is-invalid @enderror" 
                                       id="fechaLimitePago" 
                                       name="fechaLimitePago" 
                                       value="{{ \Carbon\Carbon::parse($infraccion->fechaLimitePago)->format('Y-m-d') }}"> 
                                @error('fechaLimitePago') 
                                    <span class="invalid-feedback" role="alert"> 
                                        <strong>{{ $message }}</strong> 
                                    </span> 
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estadoPago">Estado de Pago</label>
                                <select class="form-control @error('estadoPago') is-invalid @enderror" 
                                        id="estadoPago" 
                                        name="estadoPago">
                                    <option value="">Seleccione estado...</option>
                                    <option value="Pendiente" {{ $infraccion->estadoPago == 'Pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="Pagado" {{ $infraccion->estadoPago == 'Pagado' ? 'selected' : '' }}>
                                        Pagado
                                    </option>
                                    <option value="Vencido" {{ $infraccion->estadoPago == 'Vencido' ? 'selected' : '' }}>
                                        Vencido
                                    </option>
                                </select>
                                @error('estadoPago')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="documentoAdjunto">Documento Adjunto (PDF, JPG, PNG - Máx 2MB)</label>
                        
                        @if($infraccion->documentoAdjunto)
                            <div class="mb-2">
                                <small class="text-muted">Documento actual: </small>
                                <a href="{{ asset('storage/' . $infraccion->documentoAdjunto) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-secondary">
                                    <i class="fas fa-file-pdf"></i> Ver documento
                                </a>
                            </div>
                        @endif
                        
                        <input type="file" 
                               class="form-control-file @error('documentoAdjunto') is-invalid @enderror" 
                               id="documentoAdjunto" 
                               name="documentoAdjunto"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">
                            Deje vacío si no desea cambiar el documento actual
                        </small>
                        @error('documentoAdjunto')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar
            </button> 
            <a href="{{ route('infraccion.index') }}" class="btn btn-danger">
                <i class="fas fa-ban"></i> Cancelar
            </a> 
        </form> 
    </div>      

@endsection