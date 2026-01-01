@extends('layout.plantillaGerente')
@section('titulo', 'Reporte Solicitudes')
@section('contenido')

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">Listado de Solicitudes de Servicio</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Servicio</th>
                        <th>Prioridad</th>
                        <th>Descripción</th>
                        <th>Fecha Tentativa</th>
                        <th>Estado</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $sol)
                    <tr>
                        <td>{{ $sol->id_solicitud }}</td>
                        <td>{{ $sol->descripcionServicio }}</td>
                        <td>
                            @if($sol->prioridad == 'ALTA') <span class="badge badge-danger">Alta</span>
                            @elseif($sol->prioridad == 'MEDIA') <span class="badge badge-warning">Media</span>
                            @else <span class="badge badge-success">Baja</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($sol->descripcion, 40) }}</td>
                        <td>{{ \Carbon\Carbon::parse($sol->fechaTentativaEjecucion)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($sol->estado) }}</td>
                        <td>{{ $sol->monto ? 'S/. '.number_format($sol->monto, 2) : '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">No hay datos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $solicitudes->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
