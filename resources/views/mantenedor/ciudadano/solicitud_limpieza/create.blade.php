@extends('layout.plantillaCiudadano')
@section('titulo', 'Registrar Solicitud de Limpieza')
@section('contenido')

<div class="container-fluid mt-3 px-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold m-0">REGISTRAR SOLICITUD DE LIMPIEZA</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ciudadano.solicitud.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="id_servicio">Indique un tipo de servicio:</label>
                            <select class="form-control select-wide @error('id_servicio') is-invalid @enderror" id="id_servicio" name="id_servicio">
                                <option disabled selected value="">-- Seleccione un servicio --</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id_servicio }}" {{ old('id_servicio') == $servicio->id_servicio ? 'selected' : '' }}>
                                        {{ $servicio->descripcionServicio }} 
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
                            <label for="id_area">Indique una zona (Área Verde):</label>
                            <select class="form-control select-wide @error('id_area') is-invalid @enderror" id="id_area" name="id_area">
                                <option disabled selected value="">-- Seleccione una zona --</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id_area }}" {{ old('id_area') == $area->id_area ? 'selected' : '' }}>
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
                            <label for="descripcion">Describa la situación presentada:</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <label for="prioridad">Indique el nivel de prioridad:</label>
                            <select class="form-control select-wide @error('prioridad') is-invalid @enderror" id="prioridad" name="prioridad">
                                <option disabled selected value="">-- Seleccione prioridad --</option>
                                <option value="ALTA" {{ old('prioridad') == 'ALTA' ? 'selected' : '' }}>Alta</option>
                                <option value="MEDIA" {{ old('prioridad') == 'MEDIA' ? 'selected' : '' }}>Media</option>
                                <option value="BAJA" {{ old('prioridad') == 'BAJA' ? 'selected' : '' }}>Baja</option>
                            </select>
                            @error('prioridad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="fechaTentativaEjecucion">Indique una fecha tentativa de ejecución:</label>
                            <input type="date" class="form-control @error('fechaTentativaEjecucion') is-invalid @enderror" id="fechaTentativaEjecucion" name="fechaTentativaEjecucion" value="{{ old('fechaTentativaEjecucion') }}">
                            @error('fechaTentativaEjecucion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-4 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Registrar
                            </button>
                            <a href="{{ route('ciudadano.solicitud.cancelar') }}" class="btn btn-danger ms-3"> 
                                <i class="fas fa-ban me-2"></i> Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection