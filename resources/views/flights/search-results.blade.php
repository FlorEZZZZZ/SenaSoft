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
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user-friends me-2"></i>Datos de los Pasajeros</h4>
                    </div>
                    <div class="card-body">
                        <!-- Información del vuelo -->
                        @php
                            $flightData = json_decode($flight_data, true);
                            $passengersCount = $passengers_count;
                        @endphp

                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading">Información del Vuelo:</h6>
                            <p class="mb-1"><strong>Ruta:</strong> {{ $flightData['departure']['airport'] }} → {{ $flightData['arrival']['airport'] }}</p>
                            <p class="mb-1"><strong>Vuelo:</strong> {{ $flightData['airline']['name'] }} {{ $flightData['flight']['number'] }}</p>
                            <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($departure_date)->format('d/m/Y') }}</p>
                            <p class="mb-0"><strong>Pasajeros:</strong> {{ $passengersCount }}</p>
                        </div>

                        <form method="POST" action="{{ route('bookings.store') }}">
                            @csrf
                            <input type="hidden" name="flight_data" value="{{ $flight_data }}">
                            <input type="hidden" name="passengers_count" value="{{ $passengers_count }}">
                            <input type="hidden" name="departure_date" value="{{ $departure_date }}">

                            @for($i = 1; $i <= $passengersCount; $i++)
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Pasajero {{ $i }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombres *</label>
                                                    <input type="text" class="form-control" name="passengers[{{$i}}][first_name]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Apellidos *</label>
                                                    <input type="text" class="form-control" name="passengers[{{$i}}][last_name]" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Documento *</label>
                                                    <select class="form-select" name="passengers[{{$i}}][document_type]" required>
                                                        <option value="CC">Cédula de Ciudadanía</option>
                                                        <option value="CE">Cédula de Extranjería</option>
                                                        <option value="PP">Pasaporte</option>
                                                        <option value="TI">Tarjeta de Identidad</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Número de Documento *</label>
                                                    <input type="text" class="form-control" name="passengers[{{$i}}][document_number]" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha de Nacimiento *</label>
                                                    <input type="date" class="form-control" name="passengers[{{$i}}][birth_date]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Género *</label>
                                                    <select class="form-select" name="passengers[{{$i}}][gender]" required>
                                                        <option value="M">Masculino</option>
                                                        <option value="F">Femenino</option>
                                                        <option value="O">Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Teléfono *</label>
                                                    <input type="tel" class="form-control" name="passengers[{{$i}}][phone]" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email *</label>
                                            <input type="email" class="form-control" name="passengers[{{$i}}][email]" required>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-credit-card me-2"></i> Continuar al Pago
                                </button>
                                <a href="{{ route('flights.search') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Volver a la Búsqueda
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>