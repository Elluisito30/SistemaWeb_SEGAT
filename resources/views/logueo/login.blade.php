<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>SEGAT - Inicio de Sesión</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('login/login.css') }}">

</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <div class="logo-container">
                    <img src="{{ asset('login/img/segat_Logo.png') }}" alt="SEGAT Logo">
                </div>
                <h4 class="card-title">INICIO DE SESIÓN</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('identificacion') }}">                     
                    @csrf  

                    <div class="form-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <input 
                                class="form-control @error('email') is-invalid @enderror"  
                                type="email"  
                                placeholder="ejemplo@segat.gob.pe"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                            />
                            <i class="fas fa-envelope input-icon"></i>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                class="form-control @error('password') is-invalid @enderror" 
                                type="password" 
                                placeholder="••••••••"
                                id="password" 
                                name="password"
                                required
                                autocomplete="current-password"
                            />
                            <i class="fas fa-lock input-icon"></i>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <hr class="divider" />

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Ingresar
                    </button>
                </form>
            </div>
        </div>

        <div class="copyright">
            <i class="far fa-copyright"></i> 2025 Servicio de Gestión Ambiental de Trujillo (SEGAT)
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.5/js/bootstrap.bundle.min.js"></script>

</body>
</html>