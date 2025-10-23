<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Reserva - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .seat-map {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 5px;
            padding: 10px;
        }
        .seat {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
        }
        .seat-available {
            background: #28a745;
            color: white;
        }
        .seat-occupied {
            background: #dc3545;
            cursor: not-allowed;
        }
        .seat-selected {
            background: #fd7e14;
            color: white;
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
        <!-- Mensajes de éxito/error -->
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

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">📝 Datos de los Pasajeros ({{ $passengers_count }})</h4>
                    </div>
                    <div class="card-body">
                        <!-- Información del vuelo -->
                        @php
                            $flightData = json_decode($flight_data, true);
                        @endphp

                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading">Información del Vuelo:</h6>
                            <p class="mb-1"><strong>Ruta:</strong> {{ $flightData['departure']['airport'] }} → {{ $flightData['arrival']['airport'] }}</p>
                            <p class="mb-1"><strong>Vuelo:</strong> {{ $flightData['airline']['name'] }} {{ $flightData['flight']['number'] }}</p>
                            <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($departure_date)->format('d/m/Y') }}</p>
                            <p class="mb-0"><strong>Salida:</strong> {{ \Carbon\Carbon::parse($flightData['departure']['scheduled'])->format('H:i') }}</p>
                        </div>

                        <form method="POST" action="{{ route('bookings.payment') }}">
                            @csrf
                            <input type="hidden" name="flight_data" value="{{ $flight_data }}">
                            <input type="hidden" name="passengers_count" value="{{ $passengers_count }}">
                            <input type="hidden" name="departure_date" value="{{ $departure_date }}">

                            @for($i = 0; $i < $passengers_count; $i++)
                                <div class="passenger-form mb-4 p-3 border rounded">
                                    <h5>Pasajero {{ $i + 1 }}</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Primer Nombre *</label>
                                            <input type="text" name="passengers[{{$i}}][first_name]" class="form-control @error('passengers.'.$i.'.first_name') is-invalid @enderror" 
                                                   value="{{ old('passengers.'.$i.'.first_name') }}" required>
                                            @error('passengers.'.$i.'.first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Segundo Nombre</label>
                                            <input type="text" name="passengers[{{$i}}][second_name]" class="form-control" 
                                                   value="{{ old('passengers.'.$i.'.second_name') }}">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Primer Apellido *</label>
                                            <input type="text" name="passengers[{{$i}}][last_name]" class="form-control @error('passengers.'.$i.'.last_name') is-invalid @enderror" 
                                                   value="{{ old('passengers.'.$i.'.last_name') }}" required>
                                            @error('passengers.'.$i.'.last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Segundo Apellido *</label>
                                            <input type="text" name="passengers[{{$i}}][second_last_name]" class="form-control @error('passengers.'.$i.'.second_last_name') is-invalid @enderror" 
                                                   value="{{ old('passengers.'.$i.'.second_last_name') }}" required>
                                            @error('passengers.'.$i.'.second_last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Fecha de Nacimiento *</label>
                                            <input type="date" name="passengers[{{$i}}][birth_date]" class="form-control @error('passengers.'.$i.'.birth_date') is-invalid @enderror" 
                                                   value="{{ old('passengers.'.$i.'.birth_date') }}" required>
                                            @error('passengers.'.$i.'.birth_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Género *</label>
                                            <select name="passengers[{{$i}}][gender]" class="form-select @error('passengers.'.$i.'.gender') is-invalid @enderror" required>
                                                <option value="">Seleccionar</option>
                                                <option value="Hombre" {{ old('passengers.'.$i.'.gender') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                                <option value="Mujer" {{ old('passengers.'.$i.'.gender') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                                                <option value="Otro" {{ old('passengers.'.$i.'.gender') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                            @error('passengers.'.$i.'.gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Tipo de Documento *</label>
                                            <select name="passengers[{{$i}}][document_type]" class="form-select @error('passengers.'.$i.'.document_type') is-invalid @enderror" required>
                                                <option value="">Seleccionar</option>
                                                <option value="Cedula de Ciudadania" {{ old('passengers.'.$i.'.document_type') == 'Cedula de Ciudadania' ? 'selected' : '' }}>Cédula</option>
                                                <option value="Pasaporte" {{ old('passengers.'.$i.'.document_type') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                            </select>
                                            @error('passengers.'.$i.'.document_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Número de Documento *</label>
                                            <input type="text" name="passengers[{{$i}}][document_number]" class="form-control @error('passengers.'.$i.'.document_number') is-invalid @enderror" 
                                                   value="{{ old('passengers.'.$i.'.document_number') }}" required>
                                            @error('passengers.'.$i.'.document_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Asiento *</label>
                                            <select name="passengers[{{$i}}][seat]" class="form-select seat-select @error('passengers.'.$i.'.seat') is-invalid @enderror" required>
                                                <option value="">Seleccionar asiento</option>
                                                <!-- Asientos se llenarán con JavaScript -->
                                            </select>
                                            @error('passengers.'.$i.'.seat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Celular *</label>
                                            <input type="tel" name="passengers[{{$i}}][phone]" class="form-control @error('passengers.'.$i.'.phone') is-invalid @enderror" 
                                                   value="{{ old('passengers.'.$i.'.phone') }}" required>
                                            @error('passengers.'.$i.'.phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Correo Electrónico *</label>
                                            <input type="email" name="passengers[{{$i}}][email]" class="form-control @error('passengers.'.$i.'.email') is-invalid @enderror" 
                                                   value="{{ old('passengers.'.$i.'.email') }}" required>
                                            @error('passengers.'.$i.'.email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <div class="form-check mt-3">
                                <input type="checkbox" name="terms_accepted" id="terms_accepted" class="form-check-input @error('terms_accepted') is-invalid @enderror" required>
                                <label for="terms_accepted" class="form-check-label">
                                    Acepto los términos y condiciones
                                </label>
                                @error('terms_accepted')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        <h6>{{ $flightData['departure']['airport'] }} → {{ $flightData['arrival']['airport'] }}</h6>
                        <p class="mb-1"><strong>Vuelo:</strong> {{ $flightData['airline']['name'] }} {{ $flightData['flight']['number'] }}</p>
                        <p class="mb-1"><strong>Salida:</strong> {{ \Carbon\Carbon::parse($flightData['departure']['scheduled'])->format('d/m/Y H:i') }}</p>
                        <p class="mb-1"><strong>Llegada:</strong> {{ \Carbon\Carbon::parse($flightData['arrival']['scheduled'])->format('d/m/Y H:i') }}</p>
                        <hr>
                        <h5>Total: ${{ number_format($passengers_count * 150000, 0, ',', '.') }}</h5>
                    </div>
                </div>

                <!-- Mapa de asientos MEJORADO -->
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h6 class="mb-0">
            <i class="fas fa-chair me-2"></i>Mapa de Asientos
        </h6>
    </div>
    <div class="card-body">
        <!-- Indicador de pasillo -->
        <div class="text-center mb-2">
            <small class="text-muted">▲ Frente del avión</small>
        </div>
        
        <!-- Mapa de asientos mejorado -->
        <div class="airplane-cabin">
            <!-- Primera clase -->
            <div class="cabin-section mb-4">
                <div class="cabin-label text-center mb-2">
                    <span class="badge bg-warning text-dark">Primera Clase</span>
                </div>
                <div class="seat-map-improved first-class">
                    <div class="seat-row" data-row="1">
                        <div class="row-number">1</div>
                        <div class="seats-container">
                            <div class="seat improved-seat" data-seat="1A">1A</div>
                            <div class="seat improved-seat" data-seat="1B">1B</div>
                            <div class="aisle-spacer"></div>
                            <div class="seat improved-seat" data-seat="1C">1C</div>
                            <div class="seat improved-seat" data-seat="1D">1D</div>
                        </div>
                    </div>
                    <div class="seat-row" data-row="2">
                        <div class="row-number">2</div>
                        <div class="seats-container">
                            <div class="seat improved-seat" data-seat="2A">2A</div>
                            <div class="seat improved-seat" data-seat="2B">2B</div>
                            <div class="aisle-spacer"></div>
                            <div class="seat improved-seat" data-seat="2C">2C</div>
                            <div class="seat improved-seat" data-seat="2D">2D</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clase económica -->
            <div class="cabin-section">
                <div class="cabin-label text-center mb-2">
                    <span class="badge bg-info">Clase Económica</span>
                </div>
                <div class="seat-map-improved economy-class">
                    <!-- Filas 3-10 -->
                    @for($row = 3; $row <= 10; $row++)
                    <div class="seat-row" data-row="{{ $row }}">
                        <div class="row-number">{{ $row }}</div>
                        <div class="seats-container">
                            <div class="seat improved-seat" data-seat="{{ $row }}A">{{ $row }}A</div>
                            <div class="seat improved-seat" data-seat="{{ $row }}B">{{ $row }}B</div>
                            <div class="seat improved-seat" data-seat="{{ $row }}C">{{ $row }}C</div>
                            <div class="aisle-spacer"></div>
                            <div class="seat improved-seat" data-seat="{{ $row }}D">{{ $row }}D</div>
                            <div class="seat improved-seat" data-seat="{{ $row }}E">{{ $row }}E</div>
                            <div class="seat improved-seat" data-seat="{{ $row }}F">{{ $row }}F</div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Información de selección -->
        <div class="selection-info mt-3 p-3 bg-light rounded">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-2">Asientos Seleccionados:</h6>
                    <div id="selected-seats-list" class="selected-seats-container">
                        <span class="text-muted">Ningún asiento seleccionado</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="seat-legend-improved">
                        <h6 class="mb-2">Leyenda:</h6>
                        <div class="d-flex align-items-center mb-2">
                            <div class="legend-seat available"></div>
                            <small class="ms-2">Disponible</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="legend-seat occupied"></div>
                            <small class="ms-2">Ocupado</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="legend-seat selected"></div>
                            <small class="ms-2">Seleccionado</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="legend-seat emergency-exit"></div>
                            <small class="ms-2">Salida Emergencia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instrucciones -->
        <div class="instructions mt-3">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Haz clic en los asientos disponibles para seleccionarlos. Máximo {{ $passengers_count }} asiento(s).
            </small>
        </div>
    </div>
</div>

<style>
.airplane-cabin {
    max-width: 400px;
    margin: 0 auto;
}

.cabin-section {
    margin-bottom: 20px;
}

.cabin-label {
    margin-bottom: 10px;
}

.seat-map-improved {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.seat-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.row-number {
    width: 25px;
    text-align: center;
    font-weight: bold;
    font-size: 12px;
    color: #666;
}

.seats-container {
    display: flex;
    align-items: center;
    gap: 5px;
    flex: 1;
}

.aisle-spacer {
    width: 20px;
    height: 30px;
    background: linear-gradient(90deg, #f8f9fa, #e9ecef, #f8f9fa);
    border-radius: 3px;
    position: relative;
}

.aisle-spacer::after {
    content: "Pasillo";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-90deg);
    font-size: 8px;
    color: #999;
    white-space: nowrap;
}

.improved-seat {
    width: 35px;
    height: 35px;
    border: 2px solid #dee2e6;
    border-radius: 8px 8px 4px 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.improved-seat.available {
    background: #28a745;
    color: white;
    border-color: #1e7e34;
}

.improved-seat.available:hover {
    background: #218838;
    transform: scale(1.1);
}

.improved-seat.occupied {
    background: #dc3545;
    color: white;
    border-color: #c82333;
    cursor: not-allowed;
    opacity: 0.7;
}

.improved-seat.selected {
    background: #fd7e14;
    color: white;
    border-color: #e8590c;
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(253, 126, 20, 0.4);
}

.improved-seat.emergency-exit {
    background: #ffc107;
    color: #212529;
    border-color: #e0a800;
}

.improved-seat.emergency-exit::after {
    content: "🚪";
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 8px;
}

.first-class .improved-seat {
    background: #6f42c1;
    color: white;
    border-color: #5a32a3;
}

.first-class .improved-seat.available {
    background: #6f42c1;
    border-color: #5a32a3;
}

.first-class .improved-seat.available:hover {
    background: #5a32a3;
}

.seat-legend-improved {
    display: flex;
    flex-direction: column;
}

.legend-seat {
    width: 20px;
    height: 20px;
    border: 2px solid #dee2e6;
    border-radius: 4px;
}

.legend-seat.available { background: #28a745; border-color: #1e7e34; }
.legend-seat.occupied { background: #dc3545; border-color: #c82333; }
.legend-seat.selected { background: #fd7e14; border-color: #e8590c; }
.legend-seat.emergency-exit { background: #ffc107; border-color: #e0a800; }

.selected-seats-container {
    min-height: 40px;
    padding: 8px;
    border: 1px dashed #dee2e6;
    border-radius: 4px;
    background: #f8f9fa;
}

.selected-seat-badge {
    display: inline-block;
    background: #fd7e14;
    color: white;
    padding: 4px 8px;
    margin: 2px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.instructions {
    text-align: center;
    padding: 8px;
    background: #e7f3ff;
    border-radius: 4px;
    border-left: 4px solid #0d6efd;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const occupiedSeats = ['1A', '2B', '3C', '5D', '7E', '9F'];
    const emergencyExitSeats = ['4A', '4B', '4C', '4D', '4E', '4F'];
    let selectedSeats = [];

    // Inicializar asientos
    initializeSeats();

    function initializeSeats() {
        const allSeats = document.querySelectorAll('.improved-seat');
        
        allSeats.forEach(seat => {
            const seatNumber = seat.dataset.seat;
            
            // Configurar estado inicial
            if (occupiedSeats.includes(seatNumber)) {
                seat.classList.add('occupied');
                seat.style.cursor = 'not-allowed';
            } else if (emergencyExitSeats.includes(seatNumber)) {
                seat.classList.add('available', 'emergency-exit');
            } else {
                seat.classList.add('available');
            }

            // Agregar evento click solo a asientos disponibles
            if (!occupiedSeats.includes(seatNumber)) {
                seat.addEventListener('click', function() {
                    toggleSeatSelection(seatNumber);
                });
            }
        });

        updateSeatSelection();
    }

    function toggleSeatSelection(seatNumber) {
        const index = selectedSeats.indexOf(seatNumber);
        const maxSeats = {{ $passengers_count }};
        
        if (index > -1) {
            // Deseleccionar
            selectedSeats.splice(index, 1);
        } else {
            // Seleccionar
            if (selectedSeats.length >= maxSeats) {
                alert(`Máximo ${maxSeats} asiento(s) permitido(s) para ${maxSeats} pasajero(s)`);
                return;
            }
            selectedSeats.push(seatNumber);
        }

        updateSeatSelection();
        updateSelectedSeatsList();
        updateFormSelects();
    }

    function updateSeatSelection() {
        const allSeats = document.querySelectorAll('.improved-seat');
        
        allSeats.forEach(seat => {
            const seatNumber = seat.dataset.seat;
            
            // Remover todas las clases de estado
            seat.classList.remove('selected');
            
            // Aplicar clase selected si está en la lista
            if (selectedSeats.includes(seatNumber)) {
                seat.classList.add('selected');
            }
        });
    }

    function updateSelectedSeatsList() {
        const container = document.getElementById('selected-seats-list');
        
        if (selectedSeats.length === 0) {
            container.innerHTML = '<span class="text-muted">Ningún asiento seleccionado</span>';
        } else {
            container.innerHTML = selectedSeats.map(seat => 
                `<span class="selected-seat-badge">${seat}</span>`
            ).join('');
        }
    }

    function updateFormSelects() {
        const seatSelects = document.querySelectorAll('.seat-select');
        
        seatSelects.forEach((select, index) => {
            select.innerHTML = '<option value="">Seleccionar asiento</option>';
            
            // Agregar asiento seleccionado para este pasajero
            if (selectedSeats[index]) {
                const option = document.createElement('option');
                option.value = selectedSeats[index];
                option.textContent = selectedSeats[index];
                option.selected = true;
                select.appendChild(option);
            }
            
            // Agregar todos los asientos disponibles
            const allSeats = document.querySelectorAll('.improved-seat.available');
            allSeats.forEach(seatElement => {
                const seatNumber = seatElement.dataset.seat;
                if (!selectedSeats.includes(seatNumber)) {
                    const option = document.createElement('option');
                    option.value = seatNumber;
                    option.textContent = seatNumber;
                    select.appendChild(option);
                }
            });
        });
    }

    // Inicializar lista de asientos seleccionados
    updateSelectedSeatsList();
});
</script>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simulación de mapa de asientos
            const seatMap = [
                '1A', '1B', '1C', '1D', '1E', '1F',
                '2A', '2B', '2C', '2D', '2E', '2F',
                '3A', '3B', '3C', '3D', '3E', '3F',
                '4A', '4B', '4C', '4D', '4E', '4F'
            ];
            
            const occupiedSeats = ['1A', '2C', '3F'];
            let selectedSeats = [];

            function generateSeatMap() {
                const seatMapContainer = document.getElementById('seat-map');
                seatMapContainer.innerHTML = '';

                seatMap.forEach(seat => {
                    const seatElement = document.createElement('div');
                    seatElement.className = 'seat';
                    seatElement.textContent = seat;
                    seatElement.dataset.seat = seat;

                    if (occupiedSeats.includes(seat)) {
                        seatElement.classList.add('seat-occupied');
                        seatElement.style.cursor = 'not-allowed';
                    } else {
                        seatElement.classList.add('seat-available');
                        seatElement.addEventListener('click', function() {
                            selectSeat(seat);
                        });
                    }

                    seatMapContainer.appendChild(seatElement);
                });
            }

            function selectSeat(seat) {
                const index = selectedSeats.indexOf(seat);
                
                if (index > -1) {
                    selectedSeats.splice(index, 1);
                } else {
                    if (selectedSeats.length >= {{ $passengers_count }}) {
                        alert('Ya has seleccionado todos los asientos necesarios para {{ $passengers_count }} pasajeros');
                        return;
                    }
                    selectedSeats.push(seat);
                }

                updateSeatSelection();
                generateSeatMap();
            }

            function updateSeatSelection() {
                // Actualizar todos los selects de asientos
                const seatSelects = document.querySelectorAll('.seat-select');
                
                seatSelects.forEach((select, index) => {
                    select.innerHTML = '<option value="">Seleccionar asiento</option>';
                    
                    selectedSeats.forEach(seat => {
                        const option = document.createElement('option');
                        option.value = seat;
                        option.textContent = seat;
                        // Asignar asiento al pasajero correspondiente
                        if (index < selectedSeats.length) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });

                    // Agregar asientos disponibles
                    seatMap.forEach(seat => {
                        if (!occupiedSeats.includes(seat) && !selectedSeats.includes(seat)) {
                            const option = document.createElement('option');
                            option.value = seat;
                            option.textContent = seat;
                            select.appendChild(option);
                        }
                    });
                });

                // Actualizar colores en el mapa
                document.querySelectorAll('.seat').forEach(seatElement => {
                    const seatNumber = seatElement.dataset.seat;
                    if (selectedSeats.includes(seatNumber)) {
                        seatElement.className = 'seat seat-selected';
                    } else if (occupiedSeats.includes(seatNumber)) {
                        seatElement.className = 'seat seat-occupied';
                    } else {
                        seatElement.className = 'seat seat-available';
                    }
                });
            }

            generateSeatMap();
            updateSeatSelection();
        });
    </script>
</body>
</html>