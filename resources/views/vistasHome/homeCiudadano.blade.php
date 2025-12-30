@extends('layout.plantillaCiudadano')
@section('titulo', 'Home Ciudadano')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">
    
    <!-- Card contenedor general -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-body p-4">
        
        <!-- Hero Section -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);">
              <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="text-white">
                    <h4 class="font-weight-bold mb-1">
                      <i class="fas fa-user mr-2"></i>Portal del Ciudadano
                    </h4>
                    <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">
                      Bienvenido, <strong>{{ Auth::user()->name }}</strong> | 
                      <i class="fas fa-calendar-alt ml-2 mr-1"></i>{{ date('d/m/Y') }} 
                    </p>
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
                    <h5 class="font-weight-bold mb-2" style="color: #16a34a;">Portal del Ciudadano - Sistema SEGAT</h5>
                    <p class="text-muted mb-2">
                      Desde este portal puedes gestionar tus solicitudes de limpieza y reportar infracciones.
                      También puedes consultar el estado de tus multas y realizar pagos.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
          <!-- Mis Solicitudes -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-file-alt fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #16a34a;">{{ $solicitudes }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Mis Solicitudes</h6>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('ciudadano.solicitud.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-eye mr-2"></i>Ver Todas
                </a>
              </div>
            </div>
          </div>

          <!-- Infracciones -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-exclamation-circle fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #84cc16;">{{ $infracciones }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Infracciones</h6>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('ciudadano.pagos.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-list mr-2"></i>Ver Detalle
                </a>
              </div>
            </div>
          </div>

          <!-- Nueva Solicitud -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3" 
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-plus fa-2x text-white"></i>
                </div>
                <h6 class="font-weight-bold text-muted mb-2">Nueva Solicitud</h6>
                <p class="text-muted small">Solicita un servicio</p>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('ciudadano.solicitud.create') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-plus-circle mr-2"></i>Crear
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
                  <!-- Reportar Infracción -->
                  <div class="col-md-6 mb-3">
                    <a href="{{ route('ciudadano.infracciones.create') }}" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #ecfccb; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #84cc16; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-exclamation-triangle fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #84cc16;">Reportar Infracción</h6>
                          <p class="text-muted small mb-0">Denuncia una infracción ambiental</p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <!-- Consultar Pagos -->
                  <div class="col-md-6 mb-3">
                    <a href="{{ route('ciudadano.pagos.index') }}" class="text-decoration-none">
                      <div class="d-flex align-items-start action-card p-3 rounded" style="background: #d1fae5; transition: all 0.3s;">
                        <div class="icon-box mr-3" 
                             style="width: 50px; height: 50px; background: #22c55e; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                          <i class="fas fa-file-invoice-dollar fa-lg text-white"></i>
                        </div>
                        <div>
                          <h6 class="font-weight-bold mb-1" style="color: #22c55e;">Consultar Pagos</h6>
                          <p class="text-muted small mb-0">Revisa tus multas y pagos</p>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
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