<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SEGAT - @yield('titulo', 'Sistema de Gestión')</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- SEGAT Custom Theme -->
  <link rel="stylesheet" href="/general/css/segat-theme.css">
  @yield('estilos')
  
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Reportes</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Ayuda</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Buscar..." aria-label="Buscar">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge bg-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <span class="dropdown-item dropdown-header">15 Notificaciones</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-tasks mr-2"></i> 5 tareas pendientes
            <span class="float-right text-muted text-sm">hace 10 min</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-exclamation-triangle mr-2"></i> 3 actividades vencidas
            <span class="float-right text-muted text-sm">hace 2 horas</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-chart-line mr-2"></i> Nuevo reporte disponible
            <span class="float-right text-muted text-sm">hace 1 día</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <i class="fas fa-clipboard-list brand-image img-circle elevation-3 text-white" style="font-size: 2rem; margin-left: 8px;"></i>
      <span class="brand-text font-weight-bold">SEGAT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-leaf"></i>
              <p>
                Mantenimiento de<br>
                Áreas Verdes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-seedling nav-icon"></i>
                  <p>Áreas Verdes</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-briefcase nav-icon"></i>
                  <p>Actividades de mantenimiento</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-clock nav-icon"></i>
                  <p>Programación de actividades</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-file-alt nav-icon"></i>
                  <p>Solicitudes ciudadanas</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-ban"></i>
              <p>
                Procedimientos <br> Sancionadores
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-receipt nav-icon"></i>
                  <p>Infracciones</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-search nav-icon"></i>
                  <p>Detalle de infracción</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-money-bill-wave nav-icon"></i>
                  <p>Fraccionamiento y deudas</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-stream nav-icon"></i>
                  <p>Estados del procedimiento</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bell"></i>
              <p>Notificaciones</p>
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

  <!-- Formulario de Logout (fuera del menú) -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('page_title', 'Panel de Control')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
              @yield('breadcrumb')
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Carrusel SEGAT -->
      <div class="container-fluid mb-4">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div id="segatCarousel" class="carousel slide carousel-fade shadow-lg" data-bs-ride="carousel" data-bs-interval="5000">
              <!-- Indicadores del carrusel -->
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#segatCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#segatCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#segatCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#segatCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#segatCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
              </div>
              
              <!-- Items del carrusel -->
              <div class="carousel-inner rounded-3" style="height: 500px; overflow: hidden;">
                <!-- Slide 1 -->
                <div class="carousel-item active" data-bs-interval="5000">
                  <img src="/general/img/segat-slide-1.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Gestión de Actividades">
                  <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Gestión de Actividades</h5>
                    <p>Organiza y controla todas tus actividades en un solo lugar</p>
                  </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="carousel-item" data-bs-interval="5000">
                  <img src="/general/img/segat-slide-2.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Reportes en Tiempo Real">
                  <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Reportes en Tiempo Real</h5>
                    <p>Visualiza el progreso de tus proyectos al instante</p>
                  </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="carousel-item" data-bs-interval="5000">
                  <img src="/general/img/segat-slide-3.jpeg" class="d-block w-100 h-100 object-fit-cover" alt="Seguimiento de Tareas">
                  <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Seguimiento de Tareas</h5>
                    <p>Mantén a todos tus equipos informados y coordinados</p>
                  </div>
                </div>
                
                <!-- Slide 4 -->
                <div class="carousel-item" data-bs-interval="5000">
                  <img src="/general/img/segat-slide-4.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Análisis de Productividad">
                  <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Análisis de Productividad</h5>
                    <p>Mejora el rendimiento de tu equipo con datos precisos</p>
                  </div>
                </div>
                
                <!-- Slide 5 -->
                <div class="carousel-item" data-bs-interval="5000">
                  <img src="/general/img/segat-slide-5.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Integración de Equipos">
                  <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Integración de Equipos</h5>
                    <p>Colabora eficientemente con herramientas integradas</p>
                  </div>
                </div>
              </div>
              
              <!-- Controles del carrusel -->
              <button class="carousel-control-prev" type="button" data-bs-target="#segatCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#segatCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      @yield('contenido')
    </section> 
       
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versión</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2025 <a href="#">SEGAT</a>.</strong> Sistema de Gestión de Actividades de Trabajo. Todos los derechos reservados.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>

@yield('script')

<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/adminlte/dist/js/demo.js"></script>
@yield('js')
</body>
</html>