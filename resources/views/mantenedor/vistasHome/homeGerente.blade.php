@extends('layout.plantilla')

@section('titulo', 'Dashboard Gerente')

@section('contenido')
<section class="content">
  <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card welcome-card shadow-lg border-0" style="max-width: 800px; width: 100%; background: #e3f2fd;">
      <div class="card-body d-flex flex-wrap justify-content-center text-center p-4">
        
        <!-- Texto de bienvenida -->
        <div class="welcome-text w-100">
          <h3 class="text-primary font-weight-bold">¡BIENVENIDO A LA SECCIÓN GERENCIA!</h3>
          <p class="text-dark font-weight-bold mt-3" style="text-align: justify;">
            Desde esta sección podrás supervisar y gestionar todas las operaciones municipales del 
            <span class="font-weight-bold" style="color: #1976d2;">Sistema SEGAT</span>, incluyendo la aprobación de solicitudes ciudadanas,
            la administración de áreas verdes, la supervisión de trabajadores y el control general de infracciones y servicios municipales.
          </p>
          <p class="text-muted font-weight-bold" style="text-align: justify;">
            Utiliza el panel lateral para acceder a las funciones de gestión. Esta interfaz te permitirá
            coordinar eficientemente todas las actividades municipales, manteniendo un control
            organizado de solicitudes, trabajadores, áreas verdes y el seguimiento de servicios prestados a los ciudadanos.
          </p>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="row w-100 mt-3">
          <div class="col-12">
            <div class="alert alert-info">
              <h6><i class="fas fa-info-circle"></i> Funciones Principales:</h6>
              <ul class="mb-0 text-left">
                <li><strong>Aprobar Solicitudes:</strong> Revisa y aprueba las solicitudes ciudadanas</li>
                <li><strong>Gestionar Áreas Verdes:</strong> Administra los espacios verdes del municipio</li>
                <li><strong>Supervisar Trabajadores:</strong> Monitorea el desempeño del personal municipal</li>
                <li><strong>Control de Infracciones:</strong> Visualiza y gestiona las infracciones registradas</li>
                <li><strong>Reportes Generales:</strong> Accede a estadísticas y reportes del sistema</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection