@extends('layout.plantilla')

@section('titulo', 'Dashboard Trabajador')

@section('contenido')
<section class="content">
  <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card welcome-card shadow-lg border-0" style="max-width: 800px; width: 100%; background: #fff3e0;">
      <div class="card-body d-flex flex-wrap justify-content-center text-center p-4">
        
        <!-- Texto de bienvenida -->
        <div class="welcome-text w-100">
          <h3 class="text-warning font-weight-bold">¡BIENVENIDO A LA SECCIÓN TRABAJADOR!</h3>
          <p class="text-dark font-weight-bold mt-3" style="text-align: justify;">
            Desde esta sección podrás realizar tus labores diarias como trabajador municipal del 
            <span class="font-weight-bold" style="color: #f57c00;">Sistema SEGAT</span>, incluyendo el registro de infracciones,
            la atención de solicitudes asignadas, el registro de actividades realizadas y la gestión de servicios en áreas verdes.
          </p>
          <p class="text-muted font-weight-bold" style="text-align: justify;">
            Utiliza el panel lateral para acceder a tus funciones de trabajo. Esta interfaz te permitirá
            registrar eficientemente todas tus actividades diarias, mantener un control de las tareas asignadas
            y generar los reportes necesarios de tus labores en el municipio.
          </p>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="row w-100 mt-3">
          <div class="col-12">
            <div class="alert alert-warning">
              <h6><i class="fas fa-info-circle"></i> Funciones Principales:</h6>
              <ul class="mb-0 text-left">
                <li><strong>Registrar Infracciones:</strong> Documenta las infracciones encontradas en campo</li>
                <li><strong>Ver Solicitudes Asignadas:</strong> Consulta las solicitudes que debes atender</li>
                <li><strong>Registrar Actividades:</strong> Reporta las tareas realizadas en áreas verdes</li>
                <li><strong>Gestionar Servicios:</strong> Actualiza el estado de los servicios en proceso</li>
                <li><strong>Historial de Trabajo:</strong> Revisa tu registro de actividades anteriores</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection