
@extends('layout.plantillaTrabajador')
@section('titulo', 'Home Trabajador')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">
    
    <!-- Card contenedor general -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-body p-4">
        
        <!-- Hero Section compacto -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);">
              <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="text-white">
                    <h4 class="font-weight-bold mb-1">
                      <i class="fas fa-hard-hat mr-2"></i>Portal de Trabajador
                    </h4>
                    <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">
                      Bienvenido, <strong>{{ Auth::user()->name }}</strong> | 
                      <i class="fas fa-calendar-alt ml-2 mr-1"></i>{{ date('d/m/Y') }} | 
                      <i class="fas fa-clock ml-2 mr-1"></i>{{ date('H:i') }}
                    </p>
                  </div>
                  <div class="text-white d-none d-md-block">
                    <i class="fas fa-tools" style="font-size: 50px; opacity: 0.2;"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Información del Sistema -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #dcfce715 0%, #16a34a15 100%);">
              <div class="card-body p-4">
                <div class="d-flex align-items-center">
                  <div class="mr-4">
                    <i class="fas fa-info-circle fa-3x" style="color: #16a34a;"></i>
                  </div>
                  <div>
                    <h5 class="font-weight-bold mb-2" style="color: #16a34a;">Panel de Trabajador - Sistema SEGAT</h5>
                    <p class="text-muted mb-2">
                      Desde este panel podrás realizar tus labores diarias como trabajador municipal. 
                      Registra infracciones, atiende solicitudes asignadas, reporta actividades realizadas y gestiona servicios en áreas verdes.
                    </p>
                    <p class="text-muted mb-0 small">
                      <i class="fas fa-lightbulb mr-2" style="color: #84cc16;"></i>
                      <strong>Tip:</strong> Mantén actualizado el estado de tus tareas para una mejor coordinación con el equipo.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
          <!-- Tareas Asignadas -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-tasks fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #16a34a;">12</h3>
                <h6 class="font-weight-bold text-muted mb-2">Tareas Asignadas</h6>
                <small class="text-muted">Pendientes de realizar</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="#" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-eye mr-2"></i>Ver Tareas
                </a>
              </div>
            </div>
          </div>

          <!-- Infracciones Registradas -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-exclamation-triangle fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #22c55e;">8</h3>
                <h6 class="font-weight-bold text-muted mb-2">Infracciones Hoy</h6>
                <small class="text-muted">Registradas en campo</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="#" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-list mr-2"></i>Ver Registro
                </a>
              </div>
            </div>
          </div>

          <!-- Áreas Atendidas -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-map-marked-alt fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #84cc16;">15</h3>
                <h6 class="font-weight-bold text-muted mb-2">Áreas Atendidas</h6>
                <small class="text-muted">Esta semana</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="#" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-map mr-2"></i>Ver Mapa
                </a>
              </div>
            </div>
          </div>

          <!-- Actividades Completadas -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #15803d 0%, #14532d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-check-circle fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #15803d;">28</h3>
                <h6 class="font-weight-bold text-muted mb-2">Actividades Completadas</h6>
                <small class="text-muted">Este mes</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="#" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-history mr-2"></i>Historial
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-header bg-white border-0 pt-4 pb-3">
                <h5 class="font-weight-bold mb-0">
                  <i class="fas fa-bolt mr-2" style="color: #16a34a;"></i>Acciones Rápidas
                </h5>
              </div>
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <a href="#" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #dcfce7; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #16a34a; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-file-medical fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #16a34a;">Registrar Infracción</h6>
                          <p class="text-muted small mb-0">Documenta una nueva infracción</p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-4 mb-3">
                    <a href="#" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #d1fae5; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #22c55e; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-clipboard-check fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #22c55e;">Reportar Actividad</h6>
                          <p class="text-muted small mb-0">Registra el trabajo realizado</p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-4 mb-3">
                    <a href="#" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #ecfccb; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #84cc16; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-sync-alt fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #84cc16;">Actualizar Estado</h6>
                          <p class="text-muted small mb-0">Modifica el estado de servicios</p>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Funciones de Trabajo -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-header bg-white border-0 pt-4 pb-3">
                <h5 class="font-weight-bold mb-0">
                  <i class="fas fa-toolbox mr-2" style="color: #16a34a;"></i>Funciones de Trabajo
                </h5>
              </div>
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-ban fa-lg" style="color: #16a34a;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Registrar Infracciones</h6>
                        <p class="text-muted small mb-0">Documenta infracciones en campo</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clipboard-list fa-lg" style="color: #22c55e;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Ver Solicitudes</h6>
                        <p class="text-muted small mb-0">Consulta solicitudes asignadas</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #ecfccb; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-tree fa-lg" style="color: #84cc16;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Áreas Verdes</h6>
                        <p class="text-muted small mb-0">Gestiona mantenimiento de áreas</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-tasks fa-lg" style="color: #15803d;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Registrar Actividades</h6>
                        <p class="text-muted small mb-0">Reporta tareas realizadas</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-wrench fa-lg" style="color: #16a34a;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Gestionar Servicios</h6>
                        <p class="text-muted small mb-0">Actualiza estado de servicios</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-history fa-lg" style="color: #22c55e;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Historial de Trabajo</h6>
                        <p class="text-muted small mb-0">Revisa tus actividades anteriores</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- Fin card contenedor -->

  </div>
</section>

<style>
.card-hover:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(22, 163, 74, 0.2) !important;
}

.action-card:hover {
  transform: translateX(5px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
@endsection