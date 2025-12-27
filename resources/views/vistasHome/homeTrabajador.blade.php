@extends('layout.plantillaTrabajador')
@section('titulo', 'Home Trabajador')
@section('contenido')

@php
use App\Models\SolicitudLimpieza;
use App\Models\Infraccion;
use App\Models\RegistroInfraccion;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Auth;

// Obtener trabajador del usuario logueado
$user = Auth::user();
$trabajador = Trabajador::where('email', $user->email)->first();

// Estadísticas de solicitudes
$solicitudesRegistradas = SolicitudLimpieza::where('estado', 'registrada')->count();
$solicitudesEnAtencion = SolicitudLimpieza::where('estado', 'en atención')->count();
$solicitudesAtendidas = SolicitudLimpieza::where('estado', 'atendida')->count();

// Estadísticas de infracciones
$infraccionesPendientes = Infraccion::whereDoesntHave('detalleInfraccion.registroInfraccion')->count();

// Infracciones validadas por este trabajador (si existe)
$misInfraccionesValidadas = 0;
if ($trabajador) {
    $misInfraccionesValidadas = RegistroInfraccion::where('idtrabajador', $trabajador->idtrabajador)->count();
}
@endphp

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
                      <i class="fas fa-hard-hat mr-2"></i>Portal de Trabajador - Oficina
                    </h4>
                    <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">
                      Bienvenido, <strong>{{ Auth::user()->name }}</strong> | 
                      <i class="fas fa-calendar-alt ml-2 mr-1"></i>{{ date('d/m/Y') }} | 
                      <i class="fas fa-clock ml-2 mr-1"></i>{{ date('H:i') }}
                    </p>
                  </div>
                  <div class="text-white d-none d-md-block">
                    <i class="fas fa-user-tie" style="font-size: 50px; opacity: 0.2;"></i>
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
                      Desde este panel podrás gestionar solicitudes de limpieza y validar infracciones reportadas por ciudadanos.
                    </p>
                    <p class="text-muted mb-0 small">
                      <i class="fas fa-lightbulb mr-2" style="color: #84cc16;"></i>
                      <strong>Tip:</strong> Prioriza solicitudes con estado "ALTA" y valida infracciones con evidencia fotográfica.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarjetas de estadísticas REALES -->
        <div class="row mb-4">
          
          <!-- Solicitudes Registradas -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-inbox fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #16a34a;">{{ $solicitudesRegistradas }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Solicitudes Nuevas</h6>
                <small class="text-muted">Por revisar</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('trabajador.solicitudes.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-eye mr-2"></i>Ver Todas
                </a>
              </div>
            </div>
          </div>

          <!-- Infracciones Pendientes -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-exclamation-triangle fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #f59e0b;">{{ $infraccionesPendientes }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Infracciones Pendientes</h6>
                <small class="text-muted">Por validar</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('trabajador.infracciones.index') }}" class="btn btn-sm btn-outline-warning rounded-pill px-4">
                  <i class="fas fa-check mr-2"></i>Validar
                </a>
              </div>
            </div>
          </div>

          <!-- Solicitudes En Atención -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-spinner fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #3b82f6;">{{ $solicitudesEnAtencion }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">En Atención</h6>
                <small class="text-muted">Programadas</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('trabajador.solicitudes.index', ['estado' => 'en atención']) }}" 
                   class="btn btn-sm btn-outline-primary rounded-pill px-4">
                  <i class="fas fa-tasks mr-2"></i>Ver
                </a>
              </div>
            </div>
          </div>

          <!-- Mis Infracciones Validadas -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-user-check fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #22c55e;">{{ $misInfraccionesValidadas }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Mis Validaciones</h6>
                <small class="text-muted">Procesadas por mí</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('trabajador.infracciones.historial') }}" 
                   class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-history mr-2"></i>Ver Historial
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
                    <a href="{{ route('trabajador.solicitudes.index') }}" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #dcfce7; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #16a34a; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-clipboard-list fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #16a34a;">Gestionar Solicitudes</h6>
                          <p class="text-muted small mb-0">Ver y programar solicitudes de limpieza</p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-4 mb-3">
                    <a href="{{ route('trabajador.infracciones.index') }}" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #fef3c7; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #f59e0b; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-gavel fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #f59e0b;">Validar Infracciones</h6>
                          <p class="text-muted small mb-0">Revisar y asignar multas</p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-4 mb-3">
                    <a href="{{ route('trabajador.infracciones.historial') }}" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #d1fae5; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #22c55e; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-history fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #22c55e;">Ver Historial</h6>
                          <p class="text-muted small mb-0">Infracciones validadas por mí</p>
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
                  <i class="fas fa-briefcase mr-2" style="color: #16a34a;"></i>Mis Funciones
                </h5>
              </div>
              <div class="card-body p-4">
                <div class="row">
                  
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clipboard-list fa-lg" style="color: #16a34a;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Gestión de Solicitudes</h6>
                        <p class="text-muted small mb-0">
                          Visualiza, programa y cambia el estado de las solicitudes de limpieza.
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-gavel fa-lg" style="color: #f59e0b;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Validación de Infracciones</h6>
                        <p class="text-muted small mb-0">
                          Revisa infracciones reportadas y asigna el monto de las multas.
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3" 
                           style="width: 50px; height: 50px; background: #dbeafe; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-check fa-lg" style="color: #3b82f6;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Programación de Servicios</h6>
                        <p class="text-muted small mb-0">
                          Asigna monto y fecha programada a solicitudes (cambia a "En Atención").
                        </p>
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