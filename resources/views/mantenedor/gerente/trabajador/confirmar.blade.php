@extends('layout.plantillaGerente')
@section('titulo', 'Confirmar Eliminación')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #dc3545;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-user-times me-2"></i> ¿DESEAS ELIMINAR A ESTE TRABAJADOR?
                    </h5>
                </div>

                <div class="card-body p-4">
                    <!-- Advertencia -->
                    <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>ADVERTENCIA:</strong> Esta acción no se puede deshacer.
                    </div>

                    <!-- Datos del trabajador -->
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header" style="background-color: #f8d7da;">
                            <h6 class="mb-0 text-dark">
                                <i class="fas fa-id-card me-2"></i> <strong>Datos del Trabajador</strong>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class "col-md-6">
                                    <p class="mb-2"><strong>ID:</strong> {{ $trabajador->idtrabajador }}</p>
                                    <p class="mb-2"><strong>Nombres:</strong> {{ $trabajador->nombres }}</p>
                                    <p class="mb-2"><strong>Apellidos:</strong> {{ $trabajador->apellidos }}</p>
                                    <p class="mb-2"><strong>Edad:</strong> {{ $trabajador->edad }} años</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Email:</strong> {{ $trabajador->email }}
                                    </p>
                                    <p class="mb-2">
                                        <strong>Sexo:</strong> 
                                        @if($trabajador->sexo == 'Masculino')
                                            <span class="badge bg-primary px-2 py-1">
                                                <i class="fas fa-mars me-1"></i> Masculino
                                            </span>
                                        @else
                                            <span class="badge bg-danger px-2 py-1">
                                                <i class="fas fa-venus me-1"></i> Femenino
                                            </span>
                                        @endif
                                    </p>
                                    <p class="mb-2">
                                        <strong>Estado Civil:</strong> 
                                        <span class="badge bg-secondary px-2 py-1">
                                            {{ $trabajador->estado_civil }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de confirmación -->
                    <form method="POST" action="{{ route('trabajador.destroy', $trabajador->idtrabajador) }}" class="d-flex justify-content-center gap-3">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn text-white px-4" style="background-color: #dc3545;">
                            <i class="fas fa-trash-alt me-1"></i> SÍ, ELIMINAR
                        </button>
                        <a href="{{ route('trabajador.cancelar') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-ban me-1"></i> CANCELAR
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection