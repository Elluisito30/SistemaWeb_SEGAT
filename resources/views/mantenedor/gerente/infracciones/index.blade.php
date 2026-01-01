@extends('layout.plantillaGerente')
@section('titulo', 'Reporte Infracciones')
@section('contenido')

<div class="card shadow-sm">
    <div class="card-header bg-danger text-white">
        <h3 class="card-title">Listado de Infracciones y Multas</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Lugar</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Estado Pago</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($infracciones as $inf)
                    <tr>
                        <td>{{ $inf->id_infraccion }}</td>
                        <td>{{ $inf->lugarOcurrencia }}</td>
                        <td>{{ \Carbon\Carbon::parse($inf->fechaHora)->format('d/m/Y H:i') }}</td>
                        <td class="font-weight-bold text-danger">S/. {{ number_format($inf->montoMulta, 2) }}</td>
                        <td>
                            @if(strtolower($inf->estadoPago) == 'pagado')
                                <span class="badge badge-success">Pagado</span>
                            @else
                                <span class="badge badge-warning">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            @if($inf->documentoAdjunto)
                                <a href="{{ asset('storage/'.$inf->documentoAdjunto) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                            @else - @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">No hay datos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $infracciones->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
