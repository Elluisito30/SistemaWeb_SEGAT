@extends('layout.plantilla')
@section('titulo','Confirmar Eliminación')
@section('contenido')
    <div class="container">

        <h1>¿Desea eliminar la siguiente infracción?</h1>
        
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>ADVERTENCIA:</strong> Esta acción no se puede deshacer. 
            Se eliminará la infracción y sus registros asociados.
        </div>

        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5>Datos de la Infracción</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID Infracción:</strong> {{ $infraccion->id_infraccion }}</p>
                        <p><strong>Tipo de Documento:</strong> 
                            {{ $infraccion->detalleInfraccion->contribuyente->tipoDocumento->descripcionTipoD ?? 'N/A' }}
                        </p>
                        <p><strong>Número de Documento:</strong> 
                            {{ $infraccion->detalleInfraccion->contribuyente->numDocumento }}
                            @if($infraccion->detalleInfraccion->contribuyente->esReincidente())
                                <span class="badge badge-danger">REINCIDENTE</span>
                            @endif
                        </p>
                        <p><strong>Tipo Contribuyente:</strong> 
                            {{ $infraccion->detalleInfraccion->contribuyente->tipoContribuyente == 'N' ? 'Natural' : 'Jurídico' }}
                        </p>
                        <p><strong>Email:</strong> 
                            {{ $infraccion->detalleInfraccion->contribuyente->email ?? 'Sin email' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tipo de Infracción:</strong> 
                            {{ $infraccion->detalleInfraccion->tipoInfraccion->descripcion ?? 'Sin tipo' }}
                        </p>
                        <p><strong>Lugar de Ocurrencia:</strong> 
                            {{ $infraccion->detalleInfraccion->lugarOcurrencia }}
                        </p>
                        <p><strong>Fecha de Infracción:</strong> 
                            {{ \Carbon\Carbon::parse($infraccion->detalleInfraccion->fechaHora)->format('d/m/Y H:i') }}
                        </p>
                        <p><strong>Monto de Multa:</strong> 
                            <span class="text-danger font-weight-bold">S/ {{ number_format($infraccion->montoMulta, 2) }}</span>
                        </p>
                        <p><strong>Fecha Límite de Pago:</strong> 
                            {{ \Carbon\Carbon::parse($infraccion->fechaLimitePago)->format('d/m/Y') }}
                        </p>
                        <p><strong>Estado de Pago:</strong> 
                            @if($infraccion->estadoPago == 'Pagado')
                                <span class="badge badge-success">{{ $infraccion->estadoPago }}</span>
                            @elseif($infraccion->estadoPago == 'Pendiente')
                                <span class="badge badge-warning">{{ $infraccion->estadoPago }}</span>
                            @else
                                <span class="badge badge-danger">{{ $infraccion->estadoPago }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($infraccion->documentoAdjunto)
                    <hr>
                    <p><strong>Documento Adjunto:</strong> 
                        <a href="{{ asset('storage/' . $infraccion->documentoAdjunto) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-file-pdf"></i> Ver documento
                        </a>
                    </p>
                @endif

                <hr>
                <p><strong>Distrito:</strong> 
                    {{ $infraccion->detalleInfraccion->contribuyente->domicilio->distrito->descripcion ?? 'Sin distrito' }}
                </p>
                <p><strong>Dirección:</strong> 
                    {{ $infraccion->detalleInfraccion->contribuyente->domicilio->direccionDomi ?? 'Sin dirección' }}
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('infraccion.destroy', $infraccion->id_infraccion)}}" class="mt-3">
            @method('delete')
            @csrf 
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i> SÍ, ELIMINAR
            </button>
            <a href="{{ route('infraccion.cancelar')}}" class="btn btn-primary">
                <i class="fas fa-times-circle"></i> NO, CANCELAR
            </a>
        </form>
    </div>
@endsection