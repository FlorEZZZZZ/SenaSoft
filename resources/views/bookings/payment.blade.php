<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .payment-card {
            border: 2px solid #ffc107;
            border-radius: 15px;
        }
        .summary-card {
            background: #f8f9fa;
            border-radius: 10px;
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(!isset($bookingData) || !is_array($bookingData))
            <div class="alert alert-danger text-center">
                <h4><i class="fas fa-exclamation-triangle me-2"></i>Error en los datos</h4>
                <p>No se pudieron cargar los datos de la reserva. Por favor, regresa y completa el formulario nuevamente.</p>
                <a href="{{ route('flights.search') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Búsqueda
                </a>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card payment-card">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i> Proceso de Pago</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Resumen -->
                                <div class="col-md-5">
                                    <div class="card summary-card h-100">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">Resumen de Compra</h5>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $flightData = $bookingData['flight_data'];
                                                $passengers = $bookingData['passengers_data'];
                                            @endphp

                                            <h6 class="text-primary">{{ $flightData['departure']['airport'] }} → {{ $flightData['arrival']['airport'] }}</h6>
                                            <p class="mb-1"><strong>Vuelo:</strong> {{ $flightData['airline']['name'] }} {{ $flightData['flight']['number'] }}</p>
                                            <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($bookingData['departure_date'])->format('d/m/Y') }}</p>
                                            <p class="mb-1"><strong>Salida:</strong> {{ \Carbon\Carbon::parse($flightData['departure']['scheduled'])->format('H:i') }}</p>
                                            <p class="mb-3"><strong>Llegada:</strong> {{ \Carbon\Carbon::parse($flightData['arrival']['scheduled'])->format('H:i') }}</p>

                                            <hr>
                                            
                                            <h6>Pasajeros ({{ $bookingData['passengers_count'] }}):</h6>
                                            @foreach($passengers as $index => $passenger)
                                            <div class="mb-2">
                                                <small class="fw-bold">Pasajero {{ $index + 1 }}:</small><br>
                                                <small>{{ $passenger['first_name'] }} {{ $passenger['last_name'] }} - Asiento {{ $passenger['seat'] }}</small>
                                            </div>
                                            @endforeach

                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Total:</h5>
                                                <h4 class="text-success mb-0">${{ number_format($bookingData['total_price'], 0, ',', '.') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Métodos de Pago -->
                                <div class="col-md-7">
                                    <h5 class="mb-3">Método de Pago</h5>
                                    
                                    <form id="paymentForm" method="POST" action="{{ route('bookings.process-payment') }}">
                                        @csrf
                                        
                                        <div class="mb-4">
                                            <div class="form-check mb-3 border rounded p-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="nequi" value="nequi" required>
                                                <label class="form-check-label w-100" for="nequi">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-mobile-alt me-2 text-primary"></i>
                                                            <strong>Nequi</strong>
                                                        </div>
                                                        <small class="text-muted">Pago rápido y seguro</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-3 border rounded p-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="daviplata" value="daviplata" required>
                                                <label class="form-check-label w-100" for="daviplata">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-wallet me-2 text-info"></i>
                                                            <strong>Daviplata</strong>
                                                        </div>
                                                        <small class="text-muted">Desde tu billetera</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-3 border rounded p-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="credit_card" required>
                                                <label class="form-check-label w-100" for="creditCard">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-credit-card me-2 text-success"></i>
                                                            <strong>Tarjeta de Crédito</strong>
                                                        </div>
                                                        <small class="text-muted">Visa, Mastercard, Amex</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-3 border rounded p-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="debitCard" value="debit_card" required>
                                                <label class="form-check-label w-100" for="debitCard">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-credit-card me-2 text-warning"></i>
                                                            <strong>Tarjeta de Débito</strong>
                                                        </div>
                                                        <small class="text-muted">Pago directo</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-3 border rounded p-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="pse" value="pse" required>
                                                <label class="form-check-label w-100" for="pse">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-university me-2 text-secondary"></i>
                                                            <strong>PSE</strong>
                                                        </div>
                                                        <small class="text-muted">Pago en línea</small>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Campos para tarjeta -->
                                        <div id="cardFields" style="display: none;">
                                            <div class="mb-3">
                                                <label class="form-label">Número de Tarjeta</label>
                                                <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Fecha Expiración</label>
                                                    <input type="text" name="card_expiry" class="form-control" placeholder="MM/AA" maxlength="5">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">CVV</label>
                                                    <input type="text" name="card_cvv" class="form-control" placeholder="123" maxlength="4">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre en la Tarjeta</label>
                                                <input type="text" name="card_holder" class="form-control" placeholder="Como aparece en la tarjeta">
                                            </div>
                                        </div>

                                        <button type="submit" id="payButton" class="btn btn-success w-100 py-3" disabled>
                                            <i class="fas fa-lock me-2"></i>Pagar ${{ number_format($bookingData['total_price'], 0, ',', '.') }}
                                        </button>

                                        <div class="text-center mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt me-1"></i>
                                                Pago 100% seguro - Tus datos están protegidos
                                            </small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const cardFields = document.getElementById('cardFields');
            const payButton = document.getElementById('payButton');
            const paymentForm = document.getElementById('paymentForm');

            if (paymentMethods.length > 0) {
                paymentMethods.forEach(method => {
                    method.addEventListener('change', function() {
                        // Mostrar campos de tarjeta solo para tarjetas
                        if (this.value === 'credit_card' || this.value === 'debit_card') {
                            cardFields.style.display = 'block';
                        } else {
                            cardFields.style.display = 'none';
                        }
                        
                        // Habilitar botón de pago
                        payButton.disabled = false;
                    });
                });

                // Formatear número de tarjeta
                const cardNumberInput = document.querySelector('input[name="card_number"]');
                if (cardNumberInput) {
                    cardNumberInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                        let matches = value.match(/\d{4,16}/g);
                        let match = matches ? matches[0] : '';
                        let parts = [];
                        
                        for (let i = 0; i < match.length; i += 4) {
                            parts.push(match.substring(i, i + 4));
                        }
                        
                        if (parts.length) {
                            e.target.value = parts.join(' ');
                        } else {
                            e.target.value = value;
                        }
                    });
                }

                // Formatear fecha de expiración
                const cardExpiryInput = document.querySelector('input[name="card_expiry"]');
                if (cardExpiryInput) {
                    cardExpiryInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length >= 2) {
                            e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                        }
                    });
                }

                // Procesar pago
                paymentForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
                    if (!selectedMethod) {
                        alert('Por favor selecciona un método de pago');
                        return;
                    }

                    // Simular procesamiento
                    payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando pago...';
                    payButton.disabled = true;

                    // Enviar formulario después de 2 segundos (simulación)
                    setTimeout(() => {
                        paymentForm.submit();
                    }, 2000);
                });
            }
        });
    </script>
</body>
</html>