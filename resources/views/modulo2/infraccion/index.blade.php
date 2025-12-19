@extends('layout.plantilla')
@section('titulo','Infracciones')
@section('contenido')
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">GESTIÓN DE INFRACCIONES AMBIENTALES</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
          <a href="{{ route('infraccion.create')}}" class="btn btn-primary mt-2">
            <i class="fas fa-plus"></i> Nueva Infracción
          </a>
          
          <nav class="navbar navbar-light float-right">
            <form class="form-inline my-2 my-lg-0" method="GET">
              <input name="buscarpor" class="form-control" type="search" 
                     placeholder="Buscar por documento o lugar" 
                     aria-label="search" 
                     value="{{ $buscarpor}}">
              <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
          </nav>

          <div id="mensaje">
            @if (session('datos'))
              <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  {{ session('datos') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
            @endif
          </div>

          <table class="table table-striped table-hover mt-3">
            <thead class="thead-dark">
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Contribuyente</th>
                <th scope="col">Documento</th>
                <th scope="col">Tipo Infracción</th>
                <th scope="col">Lugar</th>
                <th scope="col">Fecha</th>
                <th scope="col">Monto Multa</th>
                <th scope="col">Límite Pago</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            
            <tbody>
              @if (count($infracciones)<=0)
              <tr>
                <td colspan="10" class="text-center">No hay registros</td>
              </tr>
              @else
                @foreach($infracciones as $iteminfraccion)
              <tr>
                <td>{{ $iteminfraccion->id_infraccion }}</td>
                <td>
                  {{ $iteminfraccion->detalleInfraccion->contribuyente->numDocumento ?? 'Sin contribuyente' }}
                  @if($iteminfraccion->detalleInfraccion->contribuyente->esReincidente())
                    <span class="badge badge-danger">REINCIDENTE</span>
                  @endif
                </td>
                <td>
                  {{ $iteminfraccion->detalleInfraccion->contribuyente->tipoDocumento->descripcionTipoD ?? 'N/A' }}
                </td>
                <td>{{ $iteminfraccion->detalleInfraccion->tipoInfraccion->descripcion ?? 'Sin tipo' }}</td>
                <td>{{ $iteminfraccion->detalleInfraccion->lugarOcurrencia }}</td>
                <td>{{ \Carbon\Carbon::parse($iteminfraccion->detalleInfraccion->fechaHora)->format('d/m/Y') }}</td>
                <td>S/ {{ number_format($iteminfraccion->montoMulta, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($iteminfraccion->fechaLimitePago)->format('d/m/Y') }}</td>
                <td>
                  @if($iteminfraccion->estadoPago == 'Pagado')
                    <span class="badge badge-success">{{ $iteminfraccion->estadoPago }}</span>
                  @elseif($iteminfraccion->estadoPago == 'Pendiente')
                    <span class="badge badge-warning">{{ $iteminfraccion->estadoPago }}</span>
                  @else
                    <span class="badge badge-danger">{{ $iteminfraccion->estadoPago }}</span>
                  @endif
                </td>
                <td>
                  <!-- Botón Ver Detalles -->
                  <a href="{{ route('infraccion.show', $iteminfraccion->id_infraccion) }}" 
                     class="btn btn-secondary btn-sm" 
                     title="Ver detalles">
                    <i class="fas fa-eye"></i>
                  </a>
                  
                  <!-- Botón Editar -->
                  <a href="{{ route('infraccion.edit', $iteminfraccion->id_infraccion) }}" 
                     class="btn btn-info btn-sm" 
                     title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  
                  <!-- Botón Eliminar -->
                  <a href="{{ route('infraccion.confirmar', $iteminfraccion->id_infraccion) }}" 
                     class="btn btn-danger btn-sm" 
                     title="Eliminar">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>            
          </table>
          
          {{ $infracciones->links() }}
        </div>
      </div>
@endsection

@section('script')
<script>
  setTimeout(function(){
    const mensaje = document.querySelector('#mensaje');
    if(mensaje) mensaje.remove();
  }, 3000);
</script>
@endsection