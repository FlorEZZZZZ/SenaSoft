<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .payment-method-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-method-card:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }
        .payment-method-card.selected {
            border-color: #0d6efd;
            background-color: #e7f1ff;
        }
        .form-check-input {
            margin-top: 0.3rem;
        }
        .card-fields, .phone-fields {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Proceso de Pago</h4>
                    </div>
                    <div class="card-body">
                        <!-- Mensajes de éxito/error -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <div class="row">
                            <!-- Resumen de Compra -->
                            <div class="col-md-5">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Resumen de Compra</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($booking))
                                            <div class="mb-3">
                                                <strong class="text-primary">Código de Reserva:</strong>
                                                <br>
                                                <span class="h5">{{ $booking['booking_code'] }}</span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <strong>Vuelo:</strong> {{ $booking['flight']['number'] }}<br>
                                                <strong>Ruta:</strong> {{ $booking['flight']['route'] }}<br>
                                                <strong>Fecha:</strong> {{ $booking['flight']['date'] }}<br>
                                                <strong>Horario:</strong> {{ $booking['flight']['time'] }}
                                            </div>

                                            <div class="mb-3">
                                                <strong>Pasajeros:</strong>
                                                <ul class="mb-0">
                                                    @foreach($booking['passengers'] as $passenger)
                                                        <li>{{ $passenger['first_name'] }} {{ $passenger['last_name'] }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            
                                            <hr>
                                            <div class="text-center">
                                                <h3 class="text-success">${{ number_format($booking['total_amount'], 0) }}</h3>
                                                <small class="text-muted">Total a pagar</small>
                                            </div>
                                        @else
                                            <div class="alert alert-warning">
                                                No hay información de reserva disponible.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Métodos de Pago -->
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0"><i class="fas fa-wallet me-2"></i>Método de Pago</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('payments.process') }}" id="paymentForm">
                                            @csrf
                                            
                                            <!-- Métodos de pago con cards -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Selecciona tu método de pago:</label>
                                                
                                                <!-- Nequi -->
                                                <div class="payment-method-card" onclick="selectPaymentMethod('nequi')">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="nequi" value="nequi" required>
                                                        <label class="form-check-label fw-bold" for="nequi">
                                                            <i class="fas fa-mobile-alt me-2 text-primary"></i>Nequi
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Daviplata -->
                                                <div class="payment-method-card" onclick="selectPaymentMethod('daviplata')">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="daviplata" value="daviplata">
                                                        <label class="form-check-label fw-bold" for="daviplata">
                                                            <i class="fas fa-wallet me-2 text-success"></i>Daviplata
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Tarjeta de Crédito -->
                                                <div class="payment-method-card" onclick="selectPaymentMethod('credit_card')">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="credit_card">
                                                        <label class="form-check-label fw-bold" for="creditCard">
                                                            <i class="fas fa-credit-card me-2 text-warning"></i>Tarjeta de Crédito
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Tarjeta de Débito -->
                                                <div class="payment-method-card" onclick="selectPaymentMethod('debit_card')">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="debitCard" value="debit_card">
                                                        <label class="form-check-label fw-bold" for="debitCard">
                                                            <i class="fas fa-credit-card me-2 text-info"></i>Tarjeta de Débito
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- PSE -->
                                                <div class="payment-method-card" onclick="selectPaymentMethod('pse')">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="pse" value="pse">
                                                        <label class="form-check-label fw-bold" for="pse">
                                                            <i class="fas fa-university me-2 text-danger"></i>PSE
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Campos para Nequi/Daviplata -->
                                            <div id="phoneFields" class="phone-fields">
                                                <div class="card border-primary mb-3">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">Información de la cuenta</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Número de teléfono</label>
                                                            <input type="tel" name="phone_number" class="form-control" placeholder="Ej: 3001234567" maxlength="10">
                                                            <small class="form-text text-muted">Ingresa el número asociado a tu cuenta</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Campos para tarjetas -->
                                            <div id="cardFields" class="card-fields">
                                                <div class="card border-warning mb-3">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">Información de la tarjeta</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Número de tarjeta</label>
                                                            <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Fecha de expiración</label>
                                                                <input type="text" name="card_expiry" class="form-control" placeholder="MM/AA" maxlength="5">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">CVV</label>
                                                                <input type="text" name="card_cvv" class="form-control" placeholder="123" maxlength="3">
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="form-label">Nombre del titular</label>
                                                            <input type="text" name="card_holder" class="form-control" placeholder="Como aparece en la tarjeta">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Información de seguridad -->
                                            <div class="alert alert-info">
                                                <i class="fas fa-shield-alt me-2"></i>
                                                <small>Tu información de pago está protegida con encriptación SSL.</small>
                                            </div>

                                            <!-- Botón de pago -->
                                            <button type="submit" class="btn btn-success btn-lg w-100" id="payButton" disabled>
                                                <i class="fas fa-lock me-2"></i>
                                                Pagar ${{ isset($booking) ? number_format($booking['total_amount'], 0) : '0' }}
                                            </button>

                                            <!-- Botón de regreso -->
                                            <a href="{{ route('bookings.create') }}" class="btn btn-outline-secondary w-100 mt-2">
                                                <i class="fas fa-arrow-left me-2"></i>Volver a la reserva
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const cardFields = document.getElementById('cardFields');
            const phoneFields = document.getElementById('phoneFields');
            const payButton = document.getElementById('payButton');
            const paymentForm = document.getElementById('paymentForm');

            // Seleccionar método de pago
            function selectPaymentMethod(method) {
                // Remover selección anterior
                document.querySelectorAll('.payment-method-card').forEach(card => {
                    card.classList.remove('selected');
                });

                // Agregar selección actual
                event.currentTarget.classList.add('selected');

                // Mostrar/ocultar campos según el método
                cardFields.style.display = 'none';
                phoneFields.style.display = 'none';

                if (method === 'credit_card' || method === 'debit_card') {
                    cardFields.style.display = 'block';
                } else if (method === 'nequi' || method === 'daviplata') {
                    phoneFields.style.display = 'block';
                }

                // Habilitar botón de pago
                payButton.disabled = false;
            }

            // Validación de formulario antes de enviar
            paymentForm.addEventListener('submit', function(e) {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
                
                if (!selectedMethod) {
                    e.preventDefault();
                    alert('❌ Por favor selecciona un método de pago.');
                    return;
                }

                // Validaciones específicas por método
                if (selectedMethod.value === 'nequi' || selectedMethod.value === 'daviplata') {
                    const phoneNumber = document.querySelector('input[name="phone_number"]');
                    if (!phoneNumber.value.trim() || phoneNumber.value.length < 10) {
                        e.preventDefault();
                        alert('❌ Por favor ingresa un número de teléfono válido (10 dígitos).');
                        phoneNumber.focus();
                        return;
                    }
                }

                if (selectedMethod.value === 'credit_card' || selectedMethod.value === 'debit_card') {
                    const cardNumber = document.querySelector('input[name="card_number"]');
                    const cardExpiry = document.querySelector('input[name="card_expiry"]');
                    const cardCvv = document.querySelector('input[name="card_cvv"]');
                    const cardHolder = document.querySelector('input[name="card_holder"]');

                    if (!cardNumber.value.trim() || cardNumber.value.length < 16) {
                        e.preventDefault();
                        alert('❌ Por favor ingresa un número de tarjeta válido.');
                        cardNumber.focus();
                        return;
                    }

                    if (!cardExpiry.value.trim() || !cardExpiry.value.includes('/')) {
                        e.preventDefault();
                        alert('❌ Por favor ingresa una fecha de expiración válida (MM/AA).');
                        cardExpiry.focus();
                        return;
                    }

                    if (!cardCvv.value.trim() || cardCvv.value.length !== 3) {
                        e.preventDefault();
                        alert('❌ Por favor ingresa un CVV válido (3 dígitos).');
                        cardCvv.focus();
                        return;
                    }

                    if (!cardHolder.value.trim()) {
                        e.preventDefault();
                        alert('❌ Por favor ingresa el nombre del titular de la tarjeta.');
                        cardHolder.focus();
                        return;
                    }
                }

                // Mostrar loading
                payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando pago...';
                payButton.disabled = true;
            });

            // Formatear número de tarjeta
            document.querySelector('input[name="card_number"]')?.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let matches = value.match(/\d{4,16}/g);
                let match = matches && matches[0] || '';
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

            // Formatear fecha de expiración
            document.querySelector('input[name="card_expiry"]')?.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
            });

            // Limitar CVV a 3 dígitos
            document.querySelector('input[name="card_cvv"]')?.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').substring(0, 3);
            });

            // Limitar teléfono a 10 dígitos
            document.querySelector('input[name="phone_number"]')?.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').substring(0, 10);
            });
        });
    </script>
</body>
</html> 