<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación - X-Fly</title>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-success">
                    <div class="card-header bg-success text-white text-center">
                        <h3 class="mb-0">✅ ¡Reserva Confirmada!</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                        <h4>Tu reserva ha sido exitosa</h4>
                        <p class="lead">Código de reserva: <strong>XF123456</strong></p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Información del Vuelo</h5>
                                        <p><strong>Vuelo:</strong> XF100</p>
                                        <p><strong>Ruta:</strong> Bogotá → Medellín</p>
                                        <p><strong>Fecha:</strong> 15 Feb 2024</p>
                                        <p><strong>Hora:</strong> 08:00 - 09:00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Información del Pasajero</h5>
                                        <p><strong>Nombre:</strong> Juan Pérez</p>
                                        <p><strong>Asiento:</strong> 4B</p>
                                        <p><strong>Documento:</strong> 123456789</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button onclick="window.print()" class="btn btn-primary me-2">
                                <i class="fas fa-print me-2"></i>Imprimir Ticket
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-download me-2"></i>Descargar PDF
                            </button>
                            <a href="/" class="btn btn-success ms-2">
                                <i class="fas fa-home me-2"></i>Volver al Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>