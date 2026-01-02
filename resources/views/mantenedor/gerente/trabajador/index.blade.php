@extends('layout.plantillaGerente')
@section('titulo', 'Trabajadores')
@section('contenido')

<div class="container-fluid p-4">
    <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #198754;">
                    <h5 class="font-weight-bold m-0">
                        <i class="fas fa-users me-2"></i> GESTIÓN DE TRABAJADORES
                    </h5>
                </div>

                <div class="card-body p-4">
                    @if(session('datos'))
                        <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Buscador y botón Nuevo Trabajador -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('trabajador.index') }}">
                                <div class="input-group shadow-sm">
                                    <input type="text" 
                                           name="buscarpor" 
                                           class="form-control border-0" 
                                           placeholder="Buscar trabajador por nombre, apellido o email..."
                                           value="{{ $buscarpor }}"
                                           style="background-color: #f8f9fa;">
                                    <button class="btn text-white" type="submit" style="background-color: #198754;">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('trabajador.create') }}" class="btn text-white" style="background-color: #28a745; border-radius: 8px; padding: 8px 16px;">
                                <i class="fas fa-plus me-2"></i> Nuevo Trabajador
                            </a>
                        </div>
                    </div>

                    <!-- Tabla de trabajadores -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" style="border-collapse: separate; border-spacing: 0 8px;">
                            <thead style="background-color: #198754; color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Edad</th>
                                    <th>Email</th>
                                    <th>Sexo</th>
                                    <th>Estado Civil</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($trabajadores->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay trabajadores registrados</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($trabajadores as $itemtrabajador)
                                        <tr class="shadow-sm" style="background-color: white;">
                                            <td>
                                                <span class="badge bg-dark px-2 py-1">#{{ $itemtrabajador->idtrabajador }}</span>
                                            </td>
                                            <td>{{ $itemtrabajador->nombres }}</td>
                                            <td>{{ $itemtrabajador->apellidos }}</td>
                                            <td>{{ $itemtrabajador->edad }} años</td>
                                            <td>{{ $itemtrabajador->email }}</td>
                                            <td>
                                                @if($itemtrabajador->sexo == 'Masculino')
                                                    <span class="badge bg-primary px-2 py-1">
                                                        <i class="fas fa-mars me-1"></i> Masculino
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger px-2 py-1">
                                                        <i class="fas fa-venus me-1"></i> Femenino
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $itemtrabajador->estado_civil }}</td>
                                            <td>
                                                <a href="{{ route('trabajador.edit', $itemtrabajador->idtrabajador) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Editar"
                                                   data-toggle="tooltip">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('trabajador.confirmar', $itemtrabajador->idtrabajador) }}" 
                                                   class="btn btn-danger btn-sm" 
                                                   title="Eliminar"
                                                   data-toggle="tooltip">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $trabajadores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Auto-ocultar mensaje
    setTimeout(() => {
        const alert = document.querySelector('.alert-dismissible');
        if (alert) {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }
    }, 3000);

    // Tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection