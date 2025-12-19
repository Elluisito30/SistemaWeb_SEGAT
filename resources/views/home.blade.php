@extends('layout.plantilla')
@section('titulo','Bienvenido')

@section('carrusel')
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
@endsection

@section('contenido')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                <strong>¡Bienvenido a SEGAT!</strong> Sistema de Gestión de Actividades de Trabajo
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-tasks" style="font-size: 3rem; color: var(--segat-accent); margin-bottom: 1rem;"></i>
                    <div class="stat-number">24</div>
                    <div class="stat-label">Tareas Activas</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users" style="font-size: 3rem; color: #17a2b8; margin-bottom: 1rem;"></i>
                    <div class="stat-number">8</div>
                    <div class="stat-label">Miembros del Equipo</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line" style="font-size: 3rem; color: #28a745; margin-bottom: 1rem;"></i>
                    <div class="stat-number">87%</div>
                    <div class="stat-label">Cumplimiento</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #ffc107; margin-bottom: 1rem;"></i>
                    <div class="stat-number">3</div>
                    <div class="stat-label">Por Vencer</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="row">
        <!-- Tareas Recientes -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list mr-2"></i>
                        Tareas Recientes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Revisar propuesta del cliente</h6>
                                <small class="text-muted">Proyecto: Implementación SEGAT</small>
                            </div>
                            <span class="badge bg-warning">En Progreso</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Actualizar documentación</h6>
                                <small class="text-muted">Proyecto: Manual de Usuario</small>
                            </div>
                            <span class="badge bg-success">Completado</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Capacitación al equipo</h6>
                                <small class="text-muted">Proyecto: Training</small>
                            </div>
                            <span class="badge bg-danger">Vencido</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Pruebas de sistema</h6>
                                <small class="text-muted">Proyecto: Control de Calidad</small>
                            </div>
                            <span class="badge bg-info">Pendiente</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-star mr-2"></i>
                        Accesos Rápidos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-plus mr-2"></i> Nueva Actividad
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-file-export mr-2"></i> Generar Reporte
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-chart-bar mr-2"></i> Ver Estadísticas
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-cog mr-2"></i> Configuración
                        </a>
                    </div>
                </div>
            </div>

            <!-- Próximos Eventos -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar mr-2"></i>
                        Próximos Eventos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">HOY</small>
                        <h6 class="mb-0">Reunión de Equipo</h6>
                        <small>2:00 PM - Sala de Conferencias</small>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted">MAÑANA</small>
                        <h6 class="mb-0">Presentación Final</h6>
                        <small>10:00 AM - Gerencia</small>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <small class="text-muted">19 NOV</small>
                        <h6 class="mb-0">Entrega de Reportes</h6>
                        <small>5:00 PM - Por correo</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Proyectos -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-briefcase mr-2"></i>
                        Proyectos Activos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <h6 class="card-title">Implementación SEGAT</h6>
                                    <small class="text-muted">Inicio: 15 Oct | Entrega: 30 Nov</small>
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div class="progress-bar bg-segat-primary" role="progressbar" style="width: 65%;"></div>
                                    </div>
                                    <small class="d-block mt-1">65% Completado</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-left-success">
                                <div class="card-body">
                                    <h6 class="card-title">Manual de Usuario</h6>
                                    <small class="text-muted">Inicio: 1 Nov | Entrega: 15 Nov</small>
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%;"></div>
                                    </div>
                                    <small class="d-block mt-1">90% Completado</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-left-warning">
                                <div class="card-body">
                                    <h6 class="card-title">Capacitación Equipo</h6>
                                    <small class="text-muted">Inicio: 10 Nov | Entrega: 25 Nov</small>
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%;"></div>
                                    </div>
                                    <small class="d-block mt-1">40% Completado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection