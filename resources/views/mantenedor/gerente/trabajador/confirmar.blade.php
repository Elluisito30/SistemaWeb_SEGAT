@extends('layout.plantillaGerente')
@section('titulo','Confirmar Eliminación')
@section('contenido')
    <div class="container">

        <h1>¿Desea eliminar el siguiente trabajador?</h1>
        
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>ADVERTENCIA:</strong> Esta acción no se puede deshacer.
        </div>

        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5>Datos del Trabajador</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $trabajador->idtrabajador }}</p>
                        <p><strong>Nombres:</strong> {{ $trabajador->nombres }}</p>
                        <p><strong>Apellidos:</strong> {{ $trabajador->apellidos }}</p>
                        <p><strong>Edad:</strong> {{ $trabajador->edad }} años</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email:</strong> {{ $trabajador->email }}</p>
                        <p><strong>Sexo:</strong> 
                            @if($trabajador->sexo == 'Masculino')
                                <span class="badge badge-primary">
                                    <i class="fas fa-mars"></i> {{ $trabajador->sexo }}
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-venus"></i> {{ $trabajador->sexo }}
                                </span>
                            @endif
                        </p>
                        <p><strong>Estado Civil:</strong> 
                            <span class="badge badge-secondary">{{ $trabajador->estado_civil }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('trabajador.destroy', $trabajador->idtrabajador)}}" class="mt-3">
            @method('delete')
            @csrf 
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i> SÍ, ELIMINAR
            </button>
            <a href="{{ route('trabajador.cancelar')}}" class="btn btn-primary">
                <i class="fas fa-times-circle"></i> NO, CANCELAR
            </a>
        </form>
    </div>
@endsection