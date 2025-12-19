<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>SEGAT - Registro de Ciudadano</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tu CSS personalizado (el mismo del login) -->
    <link rel="stylesheet" href="{{ asset('login/login.css') }}">

</head>
<body class="registro-page">  <!-- ← AGREGAR ESTA CLASE -->
    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <div class="logo-container">
                    <img src="{{ asset('login/img/segat_Logo.png') }}" alt="SEGAT Logo">
                </div>
                <h4 class="card-title">REGISTRO DE CIUDADANO</h4>
            </div>

            <div class="card-body">
                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-custom">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('registrarse') }}">                     
                    @csrf  

                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="form-label" for="name">Nombre Completo</label>
                        <div class="input-wrapper">
                            <input 
                                class="form-control @error('name') is-invalid @enderror"  
                                type="text"  
                                placeholder="Ingrese su nombre completo"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                            />
                            <i class="fas fa-user input-icon"></i>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <input 
                                class="form-control @error('email') is-invalid @enderror"  
                                type="email"  
                                placeholder="ejemplo@correo.com"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            />
                            <i class="fas fa-envelope input-icon"></i>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                class="form-control @error('password') is-invalid @enderror" 
                                type="password" 
                                placeholder="Mínimo 8 caracteres"
                                id="password" 
                                name="password"
                                required
                                autocomplete="new-password"
                            />
                            <i class="fas fa-lock input-icon"></i>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                class="form-control" 
                                type="password" 
                                placeholder="Repita su contraseña"
                                id="password_confirmation" 
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                            />
                            <i class="fas fa-lock input-icon"></i>
                        </div>
                    </div>

                    <hr class="divider" />

                    <button type="submit" class="btn-login">
                        <i class="fas fa-user-check me-2"></i> Registrarse
                    </button>
                </form>

                <a href="{{ route('login') }}" class="btn-login btn-register-green">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Inicio de Sesión
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.5/js/bootstrap.bundle.min.js"></script>

</body>
</html>