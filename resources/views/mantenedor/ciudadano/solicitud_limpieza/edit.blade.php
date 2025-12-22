
@extends('layout.plantillaCiudadano')
@section('titulo', 'Edición de Solicitud de Limpieza')
@section('contenido')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0">EDITAR SOLICITUD DE LIMPIEZA</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool text-white" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ciudadano.solicitud.update', $solicitud->id_solicitud) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="id_solicitud">Código</label>
                            <input type="text" class="form-control" id="id_solicitud" name="id_solicitud" value="{{ $solicitud->id_solicitud }}" readonly>
                        </div>

                        <div class="form-group mt-3">
                            <label for="id_servicio">Tipo de Servicio</label>
                            <select class="form-control @error('id_servicio') is-invalid @enderror" id="id_servicio" name="id_servicio">
                                <option disabled value="">-- Seleccione un servicio --</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id_servicio }}" {{ old('id_servicio', $solicitud->id_servicio) == $servicio->id_servicio ? 'selected' : '' }}>
                                        {{ $servicio->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_servicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="id_area">Zona (Área Verde)</label>
                            <select class="form-control @error('id_area') is-invalid @enderror" id="id_area" name="id_area">
                                <option disabled value="">-- Seleccione una zona --</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id_area }}" {{ old('id_area', $solicitud->detalleSolicitud->id_area) == $area->id_area ? 'selected' : '' }}>
                                        {{ $area->nombre }} - {{ $area->referencia }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_area')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $solicitud->descripcion) }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <label for="prioridad">Prioridad</label>
                            <select class="form-control @error('prioridad') is-invalid @enderror" id="prioridad" name="prioridad">
                                <option disabled value="">-- Seleccione prioridad --</option>
                                <option value="ALTA" {{ old('prioridad', $solicitud->prioridad) == 'ALTA' ? 'selected' : '' }}>Alta</option>
                                <option value="MEDIA" {{ old('prioridad', $solicitud->prioridad) == 'MEDIA' ? 'selected' : '' }}>Media</option>
                                <option value="BAJA" {{ old('prioridad', $solicitud->prioridad) == 'BAJA' ? 'selected' : '' }}>Baja</option>
                            </select>
                            @error('prioridad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="fechaTentativaEjecucion">Fecha Tentativa de Ejecución</label>
                            <input type="date" class="form-control @error('fechaTentativaEjecucion') is-invalid @enderror" id="fechaTentativaEjecucion" name="fechaTentativaEjecucion" value="{{ old('fechaTentativaEjecucion', date('Y-m-d', strtotime($solicitud->fechaTentativaEjecucion))) }}">
                            @error('fechaTentativaEjecucion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Grabar
                            </button>
                            <a href="{{ route('ciudadano.solicitud.cancelar') }}" class="btn btn-danger">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection