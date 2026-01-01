@extends('layout.plantillaGerente')
@section('titulo', 'Home Gerencia')
@section('contenido')

<section class="content pt-4">
  <div class="container-fluid">

    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
      <div class="card-body p-4">

        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);">
              <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="text-white">
                    <h4 class="font-weight-bold mb-1">
                      <i class="fas fa-user-shield mr-2"></i>Portal Gerencial
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

        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #dcfce715 0%, #16a34a15 100%);">
              <div class="card-body p-4">
                <div class="d-flex align-items-center">
                  <div class="mr-4">
                    <i class="fas fa-info-circle fa-3x" style="color: #16a34a;"></i>
                  </div>
                  <div>
                    <h5 class="font-weight-bold mb-2" style="color: #16a34a;">Sistema de Gestión Ambiental de Trujillo</h5>
                    <p class="text-muted mb-2">
                      Este módulo de gerencia te permite supervisar de manera eficiente todas las operaciones municipales del sistema SEGAT,
                      asegurando un control organizado de solicitudes ciudadanas, personal municipal, áreas verdes e infracciones registradas.
                    </p>
                    <p class="text-muted mb-0 small">
                      <i class="fas fa-lightbulb mr-2" style="color: #84cc16;"></i>
                      <strong>Tip:</strong> Utiliza el menú lateral para acceder rápidamente a todas las funciones disponibles.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3"
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-file-signature fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #16a34a;">{{ $totalSolicitudes }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Solicitudes Pendientes</h6>
                <small class="text-muted">Requieren atención</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('gerente.solicitudes') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-eye mr-2"></i>Ver Detalles
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3"
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-tree fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #22c55e;">{{ $totalAreas }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Áreas Verdes</h6>
                <small class="text-muted">Registradas en sistema</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="#" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-map-marked-alt mr-2"></i>Ver Áreas
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3"
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-users fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #84cc16;">{{ $totalTrabajadores }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Trabajadores</h6>
                <small class="text-muted">Personal activo</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('trabajador.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-users-cog mr-2"></i>Gestionar
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 card-hover" style="border-radius: 15px; transition: transform 0.3s;">
              <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto mb-3"
                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #15803d 0%, #14532d 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-exclamation-triangle fa-2x text-white"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="color: #15803d;">{{ $totalInfracciones }}</h3>
                <h6 class="font-weight-bold text-muted mb-2">Infracciones</h6>
                <small class="text-muted">Activas / Pendientes</small>
              </div>
              <div class="card-footer bg-transparent border-0 text-center pb-3">
                <a href="{{ route('gerente.infracciones') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                  <i class="fas fa-clipboard-list mr-2"></i>Revisar
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-header bg-white border-0 pt-4">
                <h5 class="font-weight-bold text-success"><i class="fas fa-chart-pie mr-2"></i>Estado de Solicitudes</h5>
              </div>
              <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="graficoSolicitudes"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-header bg-white border-0 pt-4 pb-3">
                <h5 class="font-weight-bold mb-0">
                  <i class="fas fa-tasks mr-2" style="color: #16a34a;"></i>Funciones Principales
                </h5>
              </div>
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3"
                           style="width: 50px; height: 50px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle fa-lg" style="color: #16a34a;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Aprobar Solicitudes</h6>
                        <p class="text-muted small mb-0">Revisa y aprueba las solicitudes ciudadanas</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3"
                           style="width: 50px; height: 50px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-leaf fa-lg" style="color: #22c55e;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Gestionar Áreas Verdes</h6>
                        <p class="text-muted small mb-0">Administra los espacios verdes del municipio</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3"
                           style="width: 50px; height: 50px; background: #ecfccb; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-check fa-lg" style="color: #84cc16;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Supervisar Trabajadores</h6>
                        <p class="text-muted small mb-0">Monitorea el desempeño del personal</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3"
                           style="width: 50px; height: 50px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-ban fa-lg" style="color: #15803d;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Control de Infracciones</h6>
                        <p class="text-muted small mb-0">Visualiza y gestiona las infracciones</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3"
                           style="width: 50px; height: 50px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chart-bar fa-lg" style="color: #16a34a;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Reportes Generales</h6>
                        <p class="text-muted small mb-0">Accede a estadísticas y reportes del sistema</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <div class="icon-box mr-3"
                           style="width: 50px; height: 50px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-cogs fa-lg" style="color: #22c55e;"></i>
                      </div>
                      <div>
                        <h6 class="font-weight-bold mb-1">Configuración</h6>
                        <p class="text-muted small mb-0">Gestiona parámetros del sistema</p>
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
    </div>
</section>

<style>
.card-hover:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(22, 163, 74, 0.2) !important;
}
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('graficoSolicitudes').getContext('2d');

        // Datos dinámicos desde el controlador
        const labels = {!! json_encode($labels) !!};
        const data = {!! json_encode($data) !!};

        new Chart(ctx, {
            type: 'bar', // Tipo de gráfico: barras verticales
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad de Solicitudes',
                    data: data,
                    backgroundColor: [
                        '#16a34a', // Verde
                        '#ca8a04', // Amarillo oscuro
                        '#dc2626', // Rojo
                        '#2563eb', // Azul
                        '#9333ea'  // Morado
                    ],
                    borderWidth: 1,
                    borderColor: '#ddd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 } // Solo números enteros
                    }
                },
                plugins: {
                    legend: { display: false } // Ocultar leyenda si las barras tienen etiqueta abajo
                }
            }
        });
    });
</script>
@endsection
