<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .confirmation-card {
            border: 2px solid #28a745;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.2);
        }
        .ticket-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-radius: 12px 12px 0 0;
        }
        .flight-badge {
            background: #ffc107;
            color: #212529;
            font-weight: bold;
        }
        .passenger-card {
            border-left: 4px solid #007bff;
        }
        .price-highlight {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }
        .qr-code {
            width: 120px;
            height: 120px;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        .print-only {
            display: none;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            .confirmation-card {
                border: 2px solid #000 !important;
                box-shadow: none !important;
            }
            .ticket-header {
                background: #000 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-plane me-2"></i>
                <strong>X-FLY</strong>
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('flights.search') }}" class="nav-link">
                    <i class="fas fa-search me-1"></i>Buscar Vuelos
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card confirmation-card">
                    <!-- Header -->
                    <div class="card-header ticket-header text-center py-4">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <i class="fas fa-plane fa-3x"></i>
                            </div>
                            <div class="col-md-8">
                                <h1 class="mb-2">¡Reserva Confirmada!</h1>
                                <p class="lead mb-0">Tu vuelo ha sido reservado exitosamente</p>
                            </div>
                            <div class="col-md-2">
                                <i class="fas fa-check-circle fa-3x"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Información Principal -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0">Detalles de la Reserva</h4>
                                    <span class="flight-badge badge px-3 py-2">Vuelo {{ $booking->flight_number }}</span>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>📅 Fecha de Reserva:</strong><br>
                                        {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                                        
                                        <p><strong>🔖 Referencia:</strong><br>
                                        <span class="text-primary fw-bold">{{ $booking->booking_reference }}</span></p>
                                        
                                        <p><strong>📊 Estado:</strong><br>
                                        <span class="badge bg-success">{{ ucfirst($booking->booking_status) }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>👥 Pasajeros:</strong><br>
                                        {{ $booking->passengers_count }} persona(s)</p>
                                        
                                        <p><strong>💰 Total Pagado:</strong><br>
                                        <span class="price-highlight">${{ number_format($booking->total_price, 0, ',', '.') }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="qr-code">
                                    <i class="fas fa-qrcode fa-3x text-muted"></i>
                                </div>
                                <small class="text-muted mt-2 d-block">Código QR para embarque</small>
                            </div>
                        </div>

                        <!-- Información del Vuelo -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-plane-departure me-2"></i>Información del Vuelo</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h4>{{ $booking->departure_iata }}</h4>
                                        <p class="mb-1"><strong>{{ $booking->departure_airport }}</strong></p>
                                        <p class="text-muted mb-0">{{ $booking->departure_date->format('d/m/Y') }}</p>
                                        <p class="fw-bold">{{ $booking->departure_time->format('H:i') }}</p>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-arrow-right fa-2x text-muted"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>{{ $booking->arrival_iata }}</h4>
                                        <p class="mb-1"><strong>{{ $booking->arrival_airport }}</strong></p>
                                        <p class="text-muted mb-0">{{ $booking->departure_date->format('d/m/Y') }}</p>
                                        <p class="fw-bold">{{ $booking->arrival_time->format('H:i') }}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <p><strong>Aerolínea:</strong> {{ $booking->airline }}</p>
                                        <p><strong>Duración:</strong> 
                                            @php
                                                $duration = $booking->departure_time->diff($booking->arrival_time);
                                                echo $duration->h . 'h ' . $duration->i . 'm';
                                            @endphp
                                        </p>
                                        <p><strong>Vuelo:</strong> {{ $booking->flight_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de Pasajeros -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Pasajeros</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($booking->passengers as $index => $passenger)
                                    <div class="col-md-6 mb-3">
                                        <div class="card passenger-card h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0">Pasajero {{ $index + 1 }}</h6>
                                                    <span class="badge bg-primary">{{ $passenger->seat }}</span>
                                                </div>
                                                <p class="mb-1"><strong>Nombre:</strong> 
                                                    {{ $passenger->first_name }} 
                                                    {{ $passenger->second_name ? $passenger->second_name . ' ' : '' }}
                                                    {{ $passenger->last_name }} 
                                                    {{ $passenger->second_last_name }}
                                                </p>
                                                <p class="mb-1"><strong>Documento:</strong> 
                                                    {{ $passenger->document_type }}: {{ $passenger->document_number }}
                                                </p>
                                                <p class="mb-1"><strong>Contacto:</strong> 
                                                    {{ $passenger->email }} | {{ $passenger->phone }}
                                                </p>
                                                <p class="mb-0"><strong>Nacimiento:</strong> 
                                                    {{ $passenger->birth_date->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Instrucciones -->
                        <div class="alert alert-warning no-print">
                            <h6><i class="fas fa-info-circle me-2"></i>Instrucciones Importantes</h6>
                            <ul class="mb-0">
                                <li>Presenta este documento y tu identificación en el counter de la aerolínea</li>
                                <li>Llega al aeropuerto al menos 2 horas antes del vuelo</li>
                                <li>El equipaje de mano no debe exceder 10kg</li>
                                <li>Mantén este código de reserva para cualquier consulta</li>
                            </ul>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="text-center no-print">
                            <button onclick="generatePDF()" class="btn btn-primary me-2">
                                <i class="fas fa-download me-2"></i>Descargar PDF
                            </button>
                            <button onclick="window.print()" class="btn btn-outline-primary me-2">
                                <i class="fas fa-print me-2"></i>Imprimir Ticket
                            </button>
                            <a href="{{ route('flights.search') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Nueva Búsqueda
                            </a>
                        </div>

                        <!-- Información para impresión -->
                        <div class="print-only text-center mt-4">
                            <p><strong>X-FLY Airlines</strong> | www.xfly.com | +57 1 123 4567</p>
                            <p class="text-muted">Documento generado el: {{ date('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <script>
        function generatePDF() {
            const element = document.querySelector('.confirmation-card');
            const options = {
                margin: 10,
                filename: 'reserva-xfly-{{ $booking->booking_reference }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(options).from(element).save();
        }

        // Mejorar la impresión
        window.onbeforeprint = function() {
            document.querySelector('.confirmation-card').classList.add('printing');
        };

        window.onafterprint = function() {
            document.querySelector('.confirmation-card').classList.remove('printing');
        };
    </script>
</body>
</html>