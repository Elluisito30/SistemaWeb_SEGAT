<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SEGAT - @yield('titulo', 'Sistema de Gestión')</title>
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  
  <!-- Bootstrap 4.6.2 (compatible con AdminLTE v3) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  
  <!-- SEGAT Custom Theme -->
  <link rel="stylesheet" href="{{ asset('general/css/segat-theme.css') }}">
  
  <style>
    .content-wrapper .content {
      padding: 0 !important;
    }
    
    /* NOTIFICACIONES */
    #contadorNotificaciones {
      position: absolute;
      top: -5px;
      right: -5px;
      font-size: 10px;
      padding: 3px 6px;
      border-radius: 50%;
    }
    .nav-link.position-relative {
      position: relative;
    }
    .dropdown-item {
      cursor: pointer;
    }
    .dropdown-item:hover {
      background-color: #f8f9fa;
    }
    .notification-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* FIX: Dropdown sobre sidebar */
    .dropdown-menu {
        z-index: 9999 !important;
    }
    .sidebar {
        z-index: 1030 !important;
    }
  </style>
  
  @yield('estilos')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <!-- NAVBAR SUPERIOR -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- NOTIFICACIONES -->
      <li class="nav-item dropdown">
        <a class="nav-link position-relative" href="#" id="notificacionesDropdown" data-toggle="dropdown" aria-expanded="false">
          <i class="far fa-bell fa-lg"></i>
          <span class="badge badge-danger" id="contadorNotificaciones" style="display: none;">0</span>
        </a>
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="width: 400px;">
          <div class="dropdown-header bg-success text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-bell mr-2"></i>Notificaciones</span>
            <button class="btn btn-sm btn-light" onclick="marcarTodasLeidas()">
              <i class="fas fa-check-double"></i>
            </button>
          </div>
          
          <div class="dropdown-divider"></div>
          
          <div id="listaNotificaciones" style="max-height: 400px; overflow-y: auto;">
            <div class="text-center py-3">
              <i class="fas fa-spinner fa-spin"></i> Cargando...
            </div>
          </div>
          
          <div class="dropdown-divider"></div>
          
          <a href="{{ route('trabajador.notificaciones.index') }}" class="dropdown-item dropdown-footer text-center text-success">
            Ver todas las notificaciones
          </a>
        </div>
      </li>

      <!-- Usuario -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ Auth::user()->name }}</span>
          <div class="dropdown-divider"></div>
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /NAVBAR -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link d-flex align-items-center" style="padding: 0.5rem 0.75rem;">
      <img src="{{ asset('login/img/segat_Logo.png') }}" 
          alt="Logo SEGAT" 
          class="brand-image img-circle elevation-3"
          style="opacity: .8; width: 2.25rem; height: 2.25rem; margin-right: 0.75rem;">
      <span class="brand-text font-weight-bold">SEGAT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{ route('trabajador.dashboard') }}" class="nav-link {{ request()->routeIs('trabajador.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>Inicio</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('trabajador.solicitudes.index') }}" class="nav-link {{ request()->routeIs('trabajador.solicitudes.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>Gestionar Solicitudes</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('trabajador.infracciones.index') }}" class="nav-link {{ request()->routeIs('trabajador.infracciones.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-exclamation-triangle"></i>
              <p>Validar Infracciones</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Cerrar Sesión</p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Formulario de Logout -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content">
      @yield('contenido')
    </section> 
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2025 <a href="#">SEGAT</a>.</strong> Sistema de Gestión de Actividades de Trabajo. Todos los derechos reservados.
  </footer>

</div>
<!-- ./wrapper -->

<!-- JS -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

@yield('script')

<script>
document.addEventListener('DOMContentLoaded', function() {
    cargarNotificaciones();
    setInterval(cargarNotificaciones, 30000);
});

function cargarNotificaciones() {
    fetch('{{ route('trabajador.notificaciones.noLeidas') }}')
        .then(response => response.json())
        .then(data => {
            const contador = document.getElementById('contadorNotificaciones');
            const lista = document.getElementById('listaNotificaciones');
            
            if (data.count > 0) {
                contador.textContent = data.count;
                contador.style.display = 'inline-block';
                
                const iconos = {
                    'solicitud': { icon: 'fa-clipboard-list', color: 'primary' },
                    'infraccion': { icon: 'fa-exclamation-triangle', color: 'warning' },
                    'urgente': { icon: 'fa-bell', color: 'danger' },
                    'general': { icon: 'fa-info-circle', color: 'info' }
                };
                
                let html = '';
                data.notificaciones.forEach(notif => {
                    const tipo = iconos[notif.tipo] || iconos['general'];
                    
                    html += `
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); abrirNotificacion(${notif.id_notificacion}, '${notif.url || ''}')">
                            <div class="d-flex">
                                <div class="notification-icon bg-${tipo.color} text-white mr-3">
                                    <i class="fas ${tipo.icon}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong class="d-block">${notif.titulo}</strong>
                                    <p class="mb-1 small text-muted">${notif.mensaje}</p>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> ${formatearFecha(notif.created_at)}
                                    </small>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    `;
                });
                lista.innerHTML = html;
            } else {
                contador.style.display = 'none';
                lista.innerHTML = `
                    <div class="text-center py-4">
                        <i class="far fa-bell-slash fa-3x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No hay notificaciones nuevas</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error al cargar notificaciones:', error);
            document.getElementById('listaNotificaciones').innerHTML = 
                '<div class="text-center text-danger py-3"><i class="fas fa-exclamation-circle"></i> Error al cargar</div>';
        });
}

function abrirNotificacion(id, url) {
    fetch(`{{ url('trabajador/notificaciones') }}/${id}/marcar-leida`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        if (url && url !== 'null' && url !== '') {
            window.location.href = url;
        } else {
            cargarNotificaciones();
        }
    });
}

function marcarTodasLeidas() {
    fetch('{{ route('trabajador.notificaciones.marcarTodas') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        cargarNotificaciones();
    });
}

function formatearFecha(fecha) {
    const d = new Date(fecha);
    const ahora = new Date();
    const diff = Math.floor((ahora - d) / 1000);
    
    if (diff < 60) return 'Hace unos segundos';
    if (diff < 3600) return `Hace ${Math.floor(diff / 60)} minutos`;
    if (diff < 86400) return `Hace ${Math.floor(diff / 3600)} horas`;
    
    const dias = Math.floor(diff / 86400);
    if (dias === 1) return 'Ayer';
    if (dias < 7) return `Hace ${dias} días`;
    
    return d.toLocaleDateString('es-PE', { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric' 
    });
}
</script>

@yield('js')
</body>
</html>