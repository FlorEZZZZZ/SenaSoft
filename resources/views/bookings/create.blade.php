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
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">📝 Datos de los Pasajeros</h4>
                    </div>
                    <div class="card-body">
                        <form id="booking-form">
                            <!-- Pasajero 1 -->
                            <div class="passenger-form mb-4 p-3 border rounded">
                                <h5>Pasajero 1</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Primer Nombre *</label>
                                        <input type="text" name="passengers[0][first_name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Segundo Nombre</label>
                                        <input type="text" name="passengers[0][second_name]" class="form-control">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Primer Apellido *</label>
                                        <input type="text" name="passengers[0][last_name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Segundo Apellido *</label>
                                        <input type="text" name="passengers[0][second_last_name]" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Fecha de Nacimiento *</label>
                                        <input type="date" name="passengers[0][birth_date]" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Género *</label>
                                        <select name="passengers[0][gender]" class="form-select" required>
                                            <option value="Hombre">Hombre</option>
                                            <option value="Mujer">Mujer</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tipo de Documento *</label>
                                        <select name="passengers[0][document_type]" class="form-select" required>
                                            <option value="Cedula de Ciudadania">Cédula</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Número de Documento *</label>
                                        <input type="text" name="passengers[0][document_number]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Asiento *</label>
                                        <select name="passengers[0][seat]" class="form-select seat-select" required>
                                            <option value="">Seleccionar asiento</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Celular *</label>
                                        <input type="tel" name="passengers[0][phone]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Correo Electrónico *</label>
                                        <input type="email" name="passengers[0][email]" class="form-control" required>
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
                        <h6>Bogotá → Medellín</h6>
                        <p class="mb-1"><strong>Vuelo:</strong> XF100</p>
                        <p class="mb-1"><strong>Salida:</strong> 15 Feb 2024 - 08:00</p>
                        <p class="mb-1"><strong>Llegada:</strong> 15 Feb 2024 - 09:00</p>
                        <hr>
                        <h5>Total: $250.000</h5>
                    </div>
                </div>

                <!-- Mapa de asientos -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Mapa de Asientos</h6>
                    </div>
                    <div class="card-body">
                        <div id="seat-map" class="seat-map">
                            <!-- Asientos se generarán con JavaScript -->
                        </div>
                        <div class="seat-legend mt-3">
                            <div class="d-flex align-items-center mb-1">
                                <div class="seat seat-available me-2"></div>
                                <small>Disponible</small>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <div class="seat seat-occupied me-2"></div>
                                <small>Ocupado</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="seat seat-selected me-2"></div>
                                <small>Seleccionado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    if (selectedSeats.length >= 1) { // Máximo 1 asiento por pasajero
                        alert('Solo puedes seleccionar 1 asiento por pasajero');
                        return;
                    }
                    selectedSeats.push(seat);
                }

                updateSeatSelection();
                generateSeatMap(); // Regenerar para actualizar colores
            }

            function updateSeatSelection() {
                const seatSelect = document.querySelector('.seat-select');
                seatSelect.innerHTML = '<option value="">Seleccionar asiento</option>';
                
                selectedSeats.forEach(seat => {
                    const option = document.createElement('option');
                    option.value = seat;
                    option.textContent = seat;
                    option.selected = true;
                    seatSelect.appendChild(option);
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
        });
    </script>
</body>
</html>