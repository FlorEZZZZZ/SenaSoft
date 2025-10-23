<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .register-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <h1 class="text-white">
                                <i class="fas fa-plane me-2"></i>
                                <strong>X-FLY</strong>
                            </h1>
                        </a>
                        <p class="text-white-50">Crear nueva cuenta</p>
                    </div>

                    <div class="card register-card">
                        <div class="card-header bg-success text-white text-center py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-user-plus me-2"></i>
                                Crear Cuenta
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nombres *</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Apellidos *</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Correo Electrónico *</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña *</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Confirmar Contraseña *</label>
                                            <input type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" required>
                                    <label class="form-check-label">
                                        Acepto los <a href="#">términos y condiciones</a>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-success w-100 mb-3">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Crear Cuenta
                                </button>

                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    ¿Ya tienes cuenta? Inicia Sesión
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>