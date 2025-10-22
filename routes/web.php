<!-- 

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {
    return view('flights.search');
});

Route::get('/search-results', function () {
    return view('flights.search-results');
});

Route::get('/bookings/create', function () {
    return view('bookings.create');
});

Route::get('/bookings/payment', function () {
    return view('bookings.payment');
});

Route::get('/bookings/confirmation', function () {
    return view('bookings.confirmation');
});

Route::get('/login', function () {
    return view('auth.login');
});
 -->

<!-- // web dos -->
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas PÚBLICAS (sin autenticación)
Route::get('/search', function () {
    return view('flights.search');
})->name('flights.search');

Route::get('/search-results', function () {
    return view('flights.search-results');
})->name('flights.search-results');

// Rutas PROTEGIDAS (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // Reservas
    Route::get('/bookings/create', function () {
        return view('bookings.create');
    })->name('bookings.create');
    
    Route::get('/bookings/payment', function () {
        return view('bookings.payment');
    })->name('bookings.payment');
    
    Route::get('/bookings/confirmation', function () {
        return view('bookings.confirmation');
    })->name('bookings.confirmation');
    
    // Mis reservas
    Route::get('/my-bookings', function () {
        return view('bookings.my-bookings');
    })->name('bookings.my-bookings');
    
    // Generar PDF
    Route::get('/bookings/{id}/ticket', function ($id) {
        return "PDF para reserva #{$id}";
    })->name('bookings.ticket');
});

// Rutas de ejemplo para testing
Route::get('/test-login', function () {
    return "Página de prueba después del login";
})->name('test.login');