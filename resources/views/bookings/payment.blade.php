<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - X-Fly</title>
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
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">💳 Proceso de Pago</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Resumen de Compra</h5>
                                <p><strong>Vuelo:</strong> XF100 - Bogotá a Medellín</p>
                                <p><strong>Pasajeros:</strong> 1</p>
                                <p><strong>Asiento:</strong> 4B</p>
                                <hr>
                                <h4>Total: $250.000</h4>
                            </div>
                            <div class="col-md-6">
                                <h5>Método de Pago</h5>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="nequi" value="nequi">
                                        <label class="form-check-label" for="nequi">
                                            <i class="fas fa-mobile-alt me-2"></i>Nequi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="daviplata" value="daviplata">
                                        <label class="form-check-label" for="daviplata">
                                            <i class="fas fa-wallet me-2"></i>Daviplata
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="credit_card">
                                        <label class="form-check-label" for="creditCard">
                                            <i class="fas fa-credit-card me-2"></i>Tarjeta de Crédito
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="debitCard" value="debit_card">
                                        <label class="form-check-label" for="debitCard">
                                            <i class="fas fa-credit-card me-2"></i>Tarjeta de Débito
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="pse" value="pse">
                                        <label class="form-check-label" for="pse">
                                            <i class="fas fa-university me-2"></i>PSE
                                        </label>
                                    </div>
                                </div>

                                <!-- Campos para tarjeta (se muestran solo si selecciona tarjeta) -->
                                <div id="cardFields" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Número de Tarjeta</label>
                                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Fecha Expiración</label>
                                            <input type="text" class="form-control" placeholder="MM/AA">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">CVV</label>
                                            <input type="text" class="form-control" placeholder="123">
                                        </div>
                                    </div>
                                </div>

                                <button id="payButton" class="btn btn-success w-100 mt-3" disabled>
                                    <i class="fas fa-lock me-2"></i>Pagar $250.000
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
            const cardFields = document.getElementById('cardFields');
            const payButton = document.getElementById('payButton');

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

            // Simular pago
            payButton.addEventListener('click', function() {
                const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
                if (selectedMethod) {
                    // Simular procesamiento
                    payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
                    payButton.disabled = true;
                    
                    setTimeout(() => {
                        // Simular pago exitoso (90% de probabilidad)
                        const success = Math.random() > 0.1;
                        if (success) {
                            window.location.href = '/bookings/confirmation?code=XF123456';
                        } else {
                            alert('❌ Pago fallido. Por favor intenta con otro método.');
                            payButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pagar $250.000';
                            payButton.disabled = false;
                        }
                    }, 2000);
                }
            });
        });
    </script>
</body>
</html>