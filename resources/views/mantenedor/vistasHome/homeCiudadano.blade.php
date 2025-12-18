@extends('layout.plantilla')

@section('titulo', 'Dashboard Ciudadano')

@section('contenido')
<section class="content">
  <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card welcome-card shadow-lg border-0" style="max-width: 800px; width: 100%; background: #e8f5e9;">
      <div class="card-body d-flex flex-wrap justify-content-center text-center p-4">
        
        <!-- Texto de bienvenida -->
        <div class="welcome-text w-100">
          <h3 class="text-success font-weight-bold">¡BIENVENIDO CIUDADANO!</h3>
          <p class="text-dark font-weight-bold mt-3" style="text-align: justify;">
            Desde esta sección podrás realizar todas tus gestiones como ciudadano del 
            <span class="font-weight-bold" style="color: #388e3c;">Sistema SEGAT</span>, incluyendo la creación de solicitudes de servicios,
            la consulta del estado de tus trámites, la visualización de tus infracciones y el pago de multas o fraccionamientos.
          </p>
          <p class="text-muted font-weight-bold" style="text-align: justify;">
            Utiliza el panel lateral para acceder a los servicios municipales. Esta interfaz te permitirá
            gestionar fácilmente todas tus solicitudes, consultar el estado de tus trámites,
            revisar tus obligaciones pendientes y mantenerte informado sobre los servicios disponibles en tu municipio.
          </p>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="row w-100 mt-3">
          <div class="col-12">
            <div class="alert alert-success">
              <h6><i class="fas fa-info-circle"></i> Funciones Principales:</h6>
              <ul class="mb-0 text-left">
                <li><strong>Crear Solicitudes:</strong> Solicita servicios municipales para tu área</li>
                <li><strong>Consultar Estado:</strong> Revisa el progreso de tus solicitudes</li>
                <li><strong>Ver Infracciones:</strong> Consulta las infracciones registradas a tu nombre</li>
                <li><strong>Pagar Multas:</strong> Realiza pagos o solicita fraccionamientos</li>
                <li><strong>Áreas Verdes:</strong> Conoce las áreas verdes disponibles en tu distrito</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
