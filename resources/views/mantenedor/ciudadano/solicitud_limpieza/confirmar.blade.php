
@extends('layout.plantillaCiudadano')   
@section('titulo', 'Eliminación de Solicitud')  
@section('contenido')   

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger shadow">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0"><i class="fas fa-exclamation-triangle"></i> CONFIRMAR ELIMINACIÓN</h5>
                </div>
                <div class="card-body">
                    <h5 class="text-center mb-4">
                        ¿Está seguro que desea eliminar el siguiente registro?
                    </h5>
                    <div class="text-center mb-4">
                        <strong>Código:</strong> {{ $solicitud->id_solicitud }} <br>
                        <strong>Descripción:</strong> {{ $solicitud->descripcion }} <br>
                        <strong>Zona:</strong> {{ $solicitud->detalleSolicitud->areaVerde->nombre ?? 'N/A' }} <br>
                        <strong>Prioridad:</strong> {{ $solicitud->prioridad }}
                    </div>
                    <form method="POST" action="{{ route('ciudadano.solicitud.destroy', $solicitud->id_solicitud) }}" class="text-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mr-2">
                            <i class="fas fa-check-square"></i> Confirmar
                        </button>
                        <a href="{{ route('ciudadano.solicitud.cancelar') }}" class="btn btn-secondary">
                            <i class="fas fa-times-circle"></i> Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection