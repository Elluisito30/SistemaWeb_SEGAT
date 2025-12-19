@extends('layout.plantilla')
@section('titulo','Trabajadores')
@section('contenido')
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">GESTIÓN DE TRABAJADORES</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
          <a href="{{ route('trabajador.create')}}" class="btn btn-primary mt-2">
            <i class="fas fa-plus"></i> Nuevo Trabajador
          </a>
          
          <nav class="navbar navbar-light float-right">
            <form class="form-inline my-2 my-lg-0" method="GET">
              <input name="buscarpor" class="form-control" type="search" 
                     placeholder="Buscar trabajador..." 
                     aria-label="search" 
                     value="{{ $buscarpor}}"
                     style="width: 280px;">
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
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Edad</th>
                <th scope="col">Email</th>
                <th scope="col">Sexo</th>
                <th scope="col">Estado Civil</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            
            <tbody>
              @if (count($trabajadores)<=0)
              <tr>
                <td colspan="8" class="text-center">No hay registros</td>
              </tr>
              @else
                @foreach($trabajadores as $itemtrabajador)
              <tr>
                <td>{{ $itemtrabajador->idtrabajador }}</td>
                <td>{{ $itemtrabajador->nombres }}</td>
                <td>{{ $itemtrabajador->apellidos }}</td>
                <td>{{ $itemtrabajador->edad }} años</td>
                <td>{{ $itemtrabajador->email }}</td>
                <td>
                  @if($itemtrabajador->sexo == 'Masculino')
                    <span class="badge badge-primary">
                      <i class="fas fa-mars"></i> {{ $itemtrabajador->sexo }}
                    </span>
                  @else
                    <span class="badge badge-danger">
                      <i class="fas fa-venus"></i> {{ $itemtrabajador->sexo }}
                    </span>
                  @endif
                </td>
                <td>{{ $itemtrabajador->estado_civil }}</td>
                <td>
                  <!-- Botón Editar -->
                  <a href="{{ route('trabajador.edit', $itemtrabajador->idtrabajador) }}" 
                     class="btn btn-info btn-sm"
                     title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  
                  <!-- Botón Eliminar -->
                  <a href="{{ route('trabajador.confirmar', $itemtrabajador->idtrabajador) }}" 
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
          
          {{ $trabajadores->links() }}
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