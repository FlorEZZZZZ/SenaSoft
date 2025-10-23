<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Vuelos - X-Fly</title>
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
        <!-- Mensajes -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-search me-2"></i>Buscar Vuelos</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('flights.search') }}">
                            <!-- eeee -->
                            <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="trip_type" class="form-label">Tipo de Viaje</label>
                                <select name="trip_type" id="trip_type" class="form-select" required>
                                    <option value="one_way">Solo Ida</option>
                                    <option value="round_trip">Ida y Vuelta</option>
                                </select>
                            </div>
                        </div>
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Origen (Código IATA)</label>
                                    <input type="text" class="form-control" name="origin" placeholder="Ej: BOG" required>
                                    <small class="text-muted">Código de aeropuerto: BOG, MDE, CTG, etc.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Destino (Código IATA)</label>
                                    <input type="text" class="form-control" name="destination" placeholder="Ej: MDE" required>
                                    <small class="text-muted">Código de aeropuerto: BOG, MDE, CTG, etc.</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" class="form-control" name="departure_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pasajeros</label>
                                    <select class="form-select" name="passengers" required>
                                        <option value="1">1 pasajero</option>
                                        <option value="2">2 pasajeros</option>
                                        <option value="3">3 pasajeros</option>
                                        <option value="4">4 pasajeros</option>
                                        <option value="5">5 pasajeros</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-search me-2"></i> Buscar Vuelos Disponibles
                            </button>
                        </form>
                    </div>
                </div>

<!-- Resultados de búsqueda -->
@if(isset($flights) && count($flights) > 0)
    <div class="card shadow mt-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-plane me-2"></i>Vuelos Encontrados ({{ count($flights) }})</h5>
        </div>
        <div class="card-body">
            @foreach($flights as $flight)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="card-title">
                                    {{ $flight['departure']['airport'] }} 
                                    <i class="fas fa-arrow-right mx-2"></i>
                                    {{ $flight['arrival']['airport'] }}
                                </h6>
                                <p class="mb-1">
                                    <strong>Aerolínea:</strong> {{ $flight['airline']['name'] }}
                                </p>
                                <p class="mb-1">
                                    <strong>Vuelo:</strong> {{ $flight['flight']['number'] }}
                                </p>
                                <p class="mb-1">
                                    <strong>Salida:</strong> {{ \Carbon\Carbon::parse($flight['departure']['scheduled'])->format('H:i') }}
                                </p>
                                <p class="mb-0">
                                    <strong>Llegada:</strong> {{ \Carbon\Carbon::parse($flight['arrival']['scheduled'])->format('H:i') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <form method="POST" action="{{ route('bookings.create') }}">
                                    @csrf
                                    <input type="hidden" name="flight_data" value="{{ json_encode($flight) }}">
                                    <input type="hidden" name="passengers_count" value="{{ $searchParams['passengers'] ?? 1 }}">
                                    <input type="hidden" name="departure_date" value="{{ $searchParams['departure_date'] }}">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-shopping-cart me-1"></i> Reservar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@elseif(isset($flights) && count($flights) === 0)
    <div class="alert alert-warning mt-4">
        <i class="fas fa-info-circle me-2"></i> No se encontraron vuelos para los criterios de búsqueda.
    </div>
@endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>