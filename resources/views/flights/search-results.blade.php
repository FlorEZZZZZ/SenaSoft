<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .flight-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .flight-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .price-tag {
            font-size: 1.5rem;
            font-weight: bold;
            color: #198754;
        }
        .time-display {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-plane me-2"></i>
                <strong>X-FLY</strong>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('flights.search') }}">
                    <i class="fas fa-search me-1"></i> Nueva Búsqueda
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Header de resultados -->
                <div class="card mb-4 bg-light">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="mb-1">
                                    <i class="fas fa-search me-2 text-primary"></i>Resultados de Búsqueda
                                </h2>
                                @if(isset($request))
                                <p class="text-muted mb-0">
                                    <strong>Origen:</strong> {{ $request->origin }} • 
                                    <strong>Destino:</strong> {{ $request->destination }} • 
                                    <strong>Fecha:</strong> {{ $request->departure_date }} • 
                                    <strong>Pasajeros:</strong> {{ $request->passengers }}
                                </p>
                                @endif
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-primary fs-6">
                                    {{ $outboundFlights->count() }} vuelos encontrados
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vuelos encontrados -->
                @if($outboundFlights->count() > 0)
                    <div class="row">
                        @foreach($outboundFlights as $flight)
                        <div class="col-12 mb-4">
                            <div class="card flight-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <!-- Información del vuelo -->
                                        <div class="col-md-3">
                                            <h5 class="text-primary mb-1">{{ $flight->flight_number }}</h5>
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-plane me-1"></i>
                                                {{ $flight->plane->model ?? 'Avión' }}
                                            </p>
                                            <span class="badge bg-success">
                                                <i class="fas fa-chair me-1"></i>
                                                {{ $flight->available_seats }} asientos
                                            </span>
                                        </div>

                                        <!-- Horarios y rutas -->
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-center">
                                                    <div class="time-display text-dark">
                                                        {{ $flight->departure_time->format('H:i') }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $flight->originAirport->city ?? 'Origen' }}
                                                        <br>
                                                        ({{ $flight->originAirport->code ?? 'XXX' }})
                                                    </small>
                                                </div>
                                                
                                                <div class="text-center mx-3">
                                                    <div class="text-muted small">
                                                        {{ $flight->duration ?? '1h 00m' }}
                                                    </div>
                                                    <div class="text-primary">
                                                        <i class="fas fa-plane"></i>
                                                    </div>
                                                    <div class="text-muted small">
                                                        Directo
                                                    </div>
                                                </div>
                                                
                                                <div class="text-center">
                                                    <div class="time-display text-dark">
                                                        {{ $flight->arrival_time->format('H:i') }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $flight->destinationAirport->city ?? 'Destino' }}
                                                        <br>
                                                        ({{ $flight->destinationAirport->code ?? 'XXX' }})
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Precio y acción -->
                                        <div class="col-md-3 text-center">
                                            <div class="price-tag mb-2">
                                                ${{ number_format($flight->price, 0) }}
                                            </div>
                                            <small class="text-muted d-block">
                                                Precio por persona
                                            </small>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <a href="{{ route('bookings.create') }}" 
                                               class="btn btn-primary btn-lg w-100">
                                                <i class="fas fa-ticket-alt me-1"></i>
                                                Reservar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- No hay resultados -->
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-plane-slash fa-4x text-muted mb-3"></i>
                            <h3 class="text-muted">No se encontraron vuelos</h3>
                            <p class="text-muted mb-4">
                                No hay vuelos disponibles para los criterios de búsqueda especificados.
                            </p>
                            <a href="{{ route('flights.search') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Realizar Nueva Búsqueda
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Vuelos de retorno (si aplica) -->
                @if($returnFlights->count() > 0)
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="mb-4">
                            <i class="fas fa-undo me-2 text-info"></i>Vuelos de Retorno
                        </h3>
                        @foreach($returnFlights as $flight)
                        <!-- Misma estructura que vuelos de ida -->
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Botón de nueva búsqueda -->
                <div class="text-center mt-5">
                    <a href="{{ route('flights.search') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Realizar Nueva Búsqueda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-plane me-2"></i> X-Fly - Sistema de Reservas &copy; 2024
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 