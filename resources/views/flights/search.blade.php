<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Vuelos - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .autocomplete-suggestions {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            width: 100%;
            display: none;
        }
        .autocomplete-suggestion {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .autocomplete-suggestion:hover {
            background: #f8f9fa;
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
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-search me-2"></i>Buscar Vuelos</h4>
                    </div>
                    <div class="card-body">
                        <!-- Formulario CORREGIDO - usa POST y la ruta correcta -->
                        <form method="POST" action="{{ route('flights.search.post') }}" id="search-form">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="trip_type" class="form-label">Tipo de Viaje</label>
                                    <select name="trip_type" id="trip_type" class="form-select" required>
                                        <option value="one_way">Solo Ida</option>
                                        <option value="round_trip">Ida y Vuelta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="origin" class="form-label">Ciudad de Origen</label>
                                    <input type="text" name="origin" id="origin" class="form-control" 
                                           placeholder="Ej: Bogotá o BOG" required autocomplete="off">
                                    <div id="origin-suggestions" class="autocomplete-suggestions"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="destination" class="form-label">Ciudad de Destino</label>
                                    <input type="text" name="destination" id="destination" class="form-control" 
                                           placeholder="Ej: Medellín o MDE" required autocomplete="off">
                                    <div id="destination-suggestions" class="autocomplete-suggestions"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="departure_date" class="form-label">Fecha de Ida</label>
                                    <input type="date" name="departure_date" id="departure_date" 
                                           class="form-control" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6" id="return-date-field" style="display: none;">
                                    <label for="return_date" class="form-label">Fecha de Vuelta</label>
                                    <input type="date" name="return_date" id="return_date" 
                                           class="form-control" min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="passengers" class="form-label">Pasajeros</label>
                                    <select name="passengers" id="passengers" class="form-select" required>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'pasajero' : 'pasajeros' }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-search me-2"></i> Buscar Vuelos Disponibles
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5><i class="fas fa-info-circle me-2 text-info"></i>¿Cómo buscar?</h5>
                        <ul class="mb-0">
                            <li>Puedes escribir el nombre de la ciudad o el código del aeropuerto</li>
                            <li>Máximo 5 pasajeros por reserva</li>
                            <li>La fecha de vuelta es opcional para viajes solo de ida</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tripType = document.getElementById('trip_type');
            const returnDateField = document.getElementById('return-date-field');
            const returnDate = document.getElementById('return_date');

            // Mostrar/ocultar campo de fecha de retorno
            tripType.addEventListener('change', function() {
                if (this.value === 'round_trip') {
                    returnDateField.style.display = 'block';
                    returnDate.required = true;
                } else {
                    returnDateField.style.display = 'none';
                    returnDate.required = false;
                }
            });

            // Autocompletado para aeropuertos
            setupAutocomplete('origin');
            setupAutocomplete('destination');

            function setupAutocomplete(fieldId) {
                const input = document.getElementById(fieldId);
                const suggestions = document.getElementById(fieldId + '-suggestions');

                input.addEventListener('input', function() {
                    const query = this.value;
                    
                    if (query.length < 2) {
                        suggestions.style.display = 'none';
                        return;
                    }

                    // Llamar a la API de aeropuertos
                    fetch(`/api/airports?query=${encodeURIComponent(query)}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta');
                            }
                            return response.json();
                        })
                        .then(data => {
                            suggestions.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(airport => {
                                    const div = document.createElement('div');
                                    div.className = 'autocomplete-suggestion';
                                    div.textContent = `${airport.city} (${airport.code}) - ${airport.name}`;
                                    div.addEventListener('click', function() {
                                        input.value = airport.city;
                                        suggestions.style.display = 'none';
                                    });
                                    suggestions.appendChild(div);
                                });
                                suggestions.style.display = 'block';
                            } else {
                                suggestions.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching airports:', error);
                            suggestions.style.display = 'none';
                        });
                });

                // Ocultar sugerencias al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!input.contains(e.target) && !suggestions.contains(e.target)) {
                        suggestions.style.display = 'none';
                    }
                });

                // Cerrar sugerencias con ESC
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        suggestions.style.display = 'none';
                    }
                });
            }

            // Validación de fechas
            const departureDate = document.getElementById('departure_date');
            const returnDate = document.getElementById('return_date');

            departureDate.addEventListener('change', function() {
                if (returnDate) {
                    returnDate.min = this.value;
                }
            });

            // Prevenir envío del formulario si hay errores
            document.getElementById('search-form').addEventListener('submit', function(e) {
                const origin = document.getElementById('origin').value.trim();
                const destination = document.getElementById('destination').value.trim();
                
                if (origin === destination) {
                    e.preventDefault();
                    alert('El origen y destino no pueden ser iguales.');
                    return;
                }

                // Mostrar loading
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Buscando...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>
</html>