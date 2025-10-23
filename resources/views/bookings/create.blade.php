<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Reserva - X-Fly</title>
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
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">📝 Datos de los Pasajeros</h4>
                    </div>
                    <div class="card-body">
                        <!-- FORMULARIO ACTUALIZADO - Ahora envía a bookings.store -->
                        <form method="POST" action="{{ route('bookings.store') }}" id="booking-form">
                            @csrf
                            
                            <!-- Pasajero 1 -->
                            <div class="passenger-form mb-4 p-3 border rounded">
                                <h5>Pasajero 1 - Adulto</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Primer Nombre *</label>
                                        <input type="text" name="passengers[0][first_name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Primer Apellido *</label>
                                        <input type="text" name="passengers[0][last_name]" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Tipo de Documento *</label>
                                        <select name="passengers[0][document_type]" class="form-select" required>
                                            <option value="Cedula de Ciudadania">Cédula de Ciudadanía</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                            <option value="Cedula de Extranjeria">Cédula de Extranjería</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Número de Documento *</label>
                                        <input type="text" name="passengers[0][document_number]" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Correo Electrónico *</label>
                                        <input type="email" name="passengers[0][email]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono *</label>
                                        <input type="tel" name="passengers[0][phone]" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mt-3">
                                <input type="checkbox" name="terms_accepted" id="terms_accepted" class="form-check-input" required>
                                <label for="terms_accepted" class="form-check-label">
                                    Acepto los términos y condiciones
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 w-100">
                                <i class="fas fa-credit-card me-2"></i>Continuar al Pago
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Resumen del vuelo -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Resumen del Vuelo</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ $flight->origin }} → {{ $flight->destination }}</h6>
                        <p class="mb-1"><strong>Vuelo:</strong> {{ $flight->flight_number }}</p>
                        <p class="mb-1"><strong>Fecha:</strong> {{ $flight->departure_date }}</p>
                        <p class="mb-1"><strong>Horario:</strong> {{ $flight->departure_time }} - {{ $flight->arrival_time }}</p>
                        <hr>
                        <h5>Total: ${{ number_format($flight->price, 0) }}</h5>
                    </div>
                </div>

                <!-- Información importante -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información Importante</h6>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">
                            <ul class="mb-0 ps-3">
                                <li>Verifica que los datos sean correctos</li>
                                <li>Los pasajeros deben presentar documento de identidad</li>
                                <li>Llegar 2 horas antes del vuelo</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 