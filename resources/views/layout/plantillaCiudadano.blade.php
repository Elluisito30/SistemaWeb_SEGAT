<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEGAT - @yield('titulo', 'Sistema de Gestión')</title>

    <!-- Preconexión a Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;400i;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Bootstrap 4.6.2 (compatible con AdminLTE v3) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- SEGAT Theme -->
    <link rel="stylesheet" href="{{ asset('general/css/segat-theme.css') }}">

    <style>
        .content-wrapper .content {
            padding: 1rem !important;
        }

        /* NOTIFICACIONES */
        .dropdown-item {
            cursor: pointer;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
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
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="badge badge-danger" id="contadorNotificaciones" style="display:none;">0</span>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="width:380px; max-height:450px;">
                    <div class="dropdown-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-bell mr-2"></i>Notificaciones</span>
                        <button class="btn btn-sm btn-light" onclick="marcarTodasLeidas()">
                            <i class="fas fa-check-double"></i>
                        </button>
                    </div>
                    
                    <div class="dropdown-divider"></div>

                    <div id="listaNotificaciones" style="max-height:350px; overflow-y:auto;">
                        <div class="text-center py-3">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>
                    
                    <div class="dropdown-footer text-center">
                        <a href="{{ route('ciudadano.notificaciones.index') }}" class="text-success">
                            Ver todas las notificaciones
                        </a>
                    </div>
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

    <!-- SIDEBAR -->
    <aside class="main-sidebar sidebar-dark-success elevation-4">
        <a href="{{ route('home') }}" class="brand-link d-flex align-items-center" style="padding: 0.5rem 0.75rem;">
            <img src="{{ asset('login/img/segat_Logo.png') }}"
                 alt="SEGAT Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity:.8; width: 2.25rem; height: 2.25rem; margin-right: 0.75rem;">
            <span class="brand-text font-weight-bold">SEGAT</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('ciudadano.dashboard') }}" class="nav-link {{ request()->routeIs('ciudadano.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Registros
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('ciudadano.solicitud.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-broom"></i>
                                    <p>Solicitud de limpieza</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ciudadano.infracciones.create') }}" class="nav-link">
                                    <i class="nav-icon fas fa-exclamation-circle"></i>
                                    <p>Infracción</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('ciudadano.consultas.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Consultas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('ciudadano.pagos.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Pagos</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Cerrar Sesión</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- LOGOUT FORM -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- CONTENT -->
    <div class="content-wrapper">
        <section class="content">
            @yield('contenido')
        </section>
    </div>

    <!-- FOOTER -->
    <footer class="main-footer">
        <strong>&copy; 2025 SEGAT.</strong> Todos los derechos reservados.
    </footer>
</div>

<!-- JS -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

@yield('script')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        cargarNotificaciones();
        setInterval(cargarNotificaciones, 30000);
    });

    function cargarNotificaciones() {
        fetch('{{ route('ciudadano.notificaciones.noLeidas') }}')
            .then(r => r.json())
            .then(data => {
                const contador = document.getElementById('contadorNotificaciones');
                const lista = document.getElementById('listaNotificaciones');

                if (data.count > 0) {
                    contador.textContent = data.count;
                    contador.style.display = 'inline-block';
                    
                    const iconos = {
                        'multa': 'fa-exclamation-triangle text-danger',
                        'solicitud': 'fa-clipboard-list text-primary',
                        'pago': 'fa-dollar-sign text-success',
                        'general': 'fa-info-circle text-info'
                    };
                    
                    lista.innerHTML = data.notificaciones.map(n => `
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); abrirNotificacion(${n.id_notificacion}, '${n.url || ''}')">
                            <div class="d-flex">
                                <i class="fas ${iconos[n.tipo] || iconos['general']} fa-2x mr-3 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong class="d-block">${n.titulo}</strong>
                                    <p class="mb-0 small text-muted">${n.mensaje}</p>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> ${formatearFecha(n.created_at)}
                                    </small>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    `).join('');
                } else {
                    contador.style.display = 'none';
                    lista.innerHTML = `
                        <div class="text-center text-muted py-4">
                            <i class="far fa-bell-slash fa-3x mb-2"></i>
                            <p class="mb-0">No hay notificaciones</p>
                        </div>
                    `;
                }
            })
            .catch(err => {
                console.error('Error al cargar notificaciones:', err);
                document.getElementById('listaNotificaciones').innerHTML = 
                    '<div class="text-center text-danger py-3"><i class="fas fa-exclamation-circle"></i> Error al cargar</div>';
            });
    }

    function abrirNotificacion(id, url) {
        fetch(`{{ url('ciudadano/notificaciones') }}/${id}/marcar-leida`, {
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
        fetch('{{ route('ciudadano.notificaciones.marcarTodas') }}', {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(() => cargarNotificaciones());
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
        
        return d.toLocaleDateString('es-PE', { day: '2-digit', month: 'short', year: 'numeric' });
    }
</script>

@yield('js')
</body>
</html>