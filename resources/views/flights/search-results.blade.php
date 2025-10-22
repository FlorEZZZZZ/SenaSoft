<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-plane me-2"></i>
                <strong>X-FLY</strong>
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>✈️ Resultados de Búsqueda</h2>
        
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Vuelos Encontrados</h5>
            </div>
            <div class="card-body">
                <!-- Ejemplo de vuelo -->
                <div class="flight-card border rounded p-3 mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5>XF100</h5>
                            <small class="text-muted">Airbus A320</small>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>08:00</strong>
                                    <br>
                                    <small>BOG - Bogotá</small>
                                </div>
                                <div class="text-center">
                                    <small>1h 00m</small>
                                    <br>
                                    <i class="fas fa-plane text-muted"></i>
                                </div>
                                <div>
                                    <strong>09:00</strong>
                                    <br>
                                    <small>MDE - Medellín</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <span class="badge bg-success">180 asientos</span>
                        </div>
                        <div class="col-md-3 text-end">
                            <h5>$250.000</h5>
                            <a href="/bookings/create?flight=XF100" class="btn btn-primary btn-sm">
                                Seleccionar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Más vuelos de ejemplo -->
                <div class="flight-card border rounded p-3 mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5>XF101</h5>
                            <small class="text-muted">Boeing 737</small>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>10:00</strong>
                                    <br>
                                    <small>MDE - Medellín</small>
                                </div>
                                <div class="text-center">
                                    <small>1h 00m</small>
                                    <br>
                                    <i class="fas fa-plane text-muted"></i>
                                </div>
                                <div>
                                    <strong>11:00</strong>
                                    <br>
                                    <small>BOG - Bogotá</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <span class="badge bg-success">160 asientos</span>
                        </div>
                        <div class="col-md-3 text-end">
                            <h5>$230.000</h5>
                            <a href="/bookings/create?flight=XF101" class="btn btn-primary btn-sm">
                                Seleccionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="/search" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Nueva Búsqueda
        </a>
    </div>
</body>
</html>