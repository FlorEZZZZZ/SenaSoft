<?php

use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ==================== RUTAS PÚBLICAS ====================

// Página principal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Vuelos - Búsqueda
Route::get('/search', [FlightController::class, 'search'])->name('flights.search');
Route::post('/search-flights', [FlightController::class, 'searchFlights'])->name('flights.search.post');
Route::get('/search-results', [FlightController::class, 'showSearchResults'])->name('flights.search.results');
Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flights.show');

// API para autocompletado
Route::get('/api/airports', [FlightController::class, 'getAirports']);

// ==================== RUTAS DE RESERVAS ====================

// Reservas - Formulario
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');

// Pagos
Route::get('/bookings/payment', [PaymentController::class, 'showPayment'])->name('bookings.payment');
Route::post('/payments/process', [PaymentController::class, 'processPayment'])->name('payments.process');

// Confirmación
Route::get('/bookings/confirmation', function () {
    // Datos de ejemplo para la confirmación
    $booking = session('current_booking', [
        'booking_code' => 'XF' . strtoupper(uniqid()),
        'total_amount' => 250000,
        'passengers' => [
            [
                'first_name' => 'Juan',
                'last_name' => 'Pérez',
                'document_type' => 'Cedula de Ciudadania',
                'document_number' => '123456789'
            ]
        ],
        'flight' => [
            'number' => 'XF100',
            'route' => 'Bogotá (BOG) - Medellín (MDE)',
            'date' => now()->addDay()->format('d/m/Y'),
            'time' => '08:00 - 09:00'
        ]
    ]);
    
    return view('bookings.confirmation', compact('booking'));
})->name('bookings.confirmation');

// ==================== RUTAS PROTEGIDAS (requieren autenticación) ====================

Route::middleware(['auth'])->group(function () {
    // Mis reservas
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    
    // Descargar ticket
    Route::get('/bookings/{id}/ticket', [BookingController::class, 'downloadTicket'])->name('bookings.ticket.download');
});

// ==================== RUTAS DE PRUEBA Y DEBUG ====================

// Ruta temporal para ver search-flights con estilos
Route::get('/search-flights-debug', function() {
    $sampleFlights = [
        (object)[
            'id' => 1,
            'flight_number' => 'XF100',
            'departure_time' => now()->addDay()->setTime(8, 0),
            'arrival_time' => now()->addDay()->setTime(9, 0),
            'price' => 250000,
            'available_seats' => 180,
            'originAirport' => (object)['city' => 'Bogotá', 'code' => 'BOG'],
            'destinationAirport' => (object)['city' => 'Medellín', 'code' => 'MDE'],
            'plane' => (object)['model' => 'Airbus A320']
        ],
        (object)[
            'id' => 2,
            'flight_number' => 'XF101',
            'departure_time' => now()->addDay()->setTime(10, 0),
            'arrival_time' => now()->addDay()->setTime(11, 0),
            'price' => 230000,
            'available_seats' => 160,
            'originAirport' => (object)['city' => 'Medellín', 'code' => 'MDE'],
            'destinationAirport' => (object)['city' => 'Bogotá', 'code' => 'BOG'],
            'plane' => (object)['model' => 'Boeing 737']
        ]
    ];

    return view('flights.search-results', [
        'outboundFlights' => collect($sampleFlights),
        'returnFlights' => collect(),
        'request' => (object)[
            'origin' => 'Bogotá',
            'destination' => 'Medellín',
            'departure_date' => now()->addDay()->format('Y-m-d'),
            'passengers' => 1
        ]
    ]);
})->name('flights.search.debug');

// Ruta para probar payment directamente
Route::get('/test-payment', function() {
    $booking = [
        'id' => 1,
        'booking_code' => 'XF123456',
        'total_amount' => 250000,
        'passengers' => [
            ['first_name' => 'Juan', 'last_name' => 'Pérez']
        ],
        'flight' => [
            'number' => 'XF100',
            'route' => 'Bogotá (BOG) - Medellín (MDE)',
            'date' => now()->addDay()->format('d/m/Y'),
            'time' => '08:00 - 09:00'
        ]
    ];
    
    return view('bookings.payment', compact('booking'));
});

// Ruta para probar confirmation directamente
Route::get('/test-confirmation', function() {
    $booking = [
        'booking_code' => 'XF123456',
        'total_amount' => 250000,
        'passengers' => [
            [
                'first_name' => 'Juan',
                'last_name' => 'Pérez',
                'document_type' => 'Cedula de Ciudadania',
                'document_number' => '123456789'
            ]
        ],
        'flight' => [
            'number' => 'XF100',
            'route' => 'Bogotá (BOG) - Medellín (MDE)',
            'date' => now()->addDay()->format('d/m/Y'),
            'time' => '08:00 - 09:00'
        ]
    ];
    
    return view('bookings.confirmation', compact('booking'));
});

// ==================== RUTA DE FALLBACK ====================

// Ruta de fallback para manejar URLs incorrectas
Route::fallback(function () {
    return redirect()->route('home')->with('error', 'La página solicitada no existe.');
});