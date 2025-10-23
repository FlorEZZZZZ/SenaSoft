<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'flight_data' => 'required',
            'passengers_count' => 'required|integer',
            'departure_date' => 'required|date'
        ]);

        return view('bookings.create', [
            'flight_data' => $request->flight_data,
            'passengers_count' => $request->passengers_count,
            'departure_date' => $request->departure_date
        ]);
    }

    public function payment(Request $request)
    {
        Log::info('Procesando pago - Datos recibidos:', $request->all());

        $request->validate([
            'flight_data' => 'required',
            'passengers_count' => 'required|integer',
            'departure_date' => 'required|date',
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required|string|max:255',
            'passengers.*.last_name' => 'required|string|max:255',
            'passengers.*.second_last_name' => 'required|string|max:255',
            'passengers.*.birth_date' => 'required|date',
            'passengers.*.gender' => 'required|string',
            'passengers.*.document_type' => 'required|string',
            'passengers.*.document_number' => 'required|string|max:50',
            'passengers.*.seat' => 'required|string|max:10',
            'passengers.*.phone' => 'required|string|max:20',
            'passengers.*.email' => 'required|email',
            'terms_accepted' => 'required|accepted'
        ]);

        try {
            $flightData = json_decode($request->flight_data, true);
            $totalPrice = $request->passengers_count * 150000;

            // Guardar datos temporalmente en sesión para el pago
            $bookingData = [
                'flight_data' => $flightData,
                'passengers_data' => $request->passengers,
                'passengers_count' => $request->passengers_count,
                'departure_date' => $request->departure_date,
                'total_price' => $totalPrice,
                'booking_reference' => 'XF' . strtoupper(uniqid())
            ];

            session(['pending_booking' => $bookingData]);

            return view('bookings.payment', [
                'bookingData' => $bookingData
            ]);

        } catch (\Exception $e) {
            Log::error('Error en proceso de pago: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function processPayment(Request $request)
    {
        Log::info('Procesando pago final - Método: ' . $request->payment_method);

        try {
            $pendingBooking = session('pending_booking');
            
            if (!$pendingBooking) {
                throw new \Exception('No hay reserva pendiente de pago');
            }

            // Validar datos del pago
            $request->validate([
                'payment_method' => 'required|string|in:nequi,daviplata,credit_card,debit_card,pse'
            ]);

            // Aquí integrarías con tu pasarela de pago real
            // Por ahora simulamos un pago exitoso
            $paymentSuccess = $this->processPaymentGateway($request->payment_method);

            if (!$paymentSuccess) {
                throw new \Exception('El pago fue rechazado. Intenta con otro método.');
            }

            // Crear la reserva en la base de datos
            DB::beginTransaction();

            $flightData = $pendingBooking['flight_data'];

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'flight_number' => $flightData['flight']['number'],
                'airline' => $flightData['airline']['name'],
                'departure_airport' => $flightData['departure']['airport'],
                'arrival_airport' => $flightData['arrival']['airport'],
                'departure_iata' => $flightData['departure']['iata'],
                'arrival_iata' => $flightData['arrival']['iata'],
                'departure_date' => $pendingBooking['departure_date'],
                'departure_time' => $flightData['departure']['scheduled'],
                'arrival_time' => $flightData['arrival']['scheduled'],
                'passengers_count' => $pendingBooking['passengers_count'],
                'total_price' => $pendingBooking['total_price'],
                'booking_status' => 'confirmed',
                'booking_reference' => $pendingBooking['booking_reference'],
                'payment_method' => $request->payment_method,
                'payment_status' => 'completed',
            ]);

            Log::info('Reserva creada:', $booking->toArray());

            // Crear pasajeros
            foreach ($pendingBooking['passengers_data'] as $passengerData) {
                $passenger = Passenger::create([
                    'booking_id' => $booking->id,
                    'first_name' => $passengerData['first_name'],
                    'second_name' => $passengerData['second_name'] ?? null,
                    'last_name' => $passengerData['last_name'],
                    'second_last_name' => $passengerData['second_last_name'],
                    'birth_date' => $passengerData['birth_date'],
                    'gender' => $passengerData['gender'],
                    'document_type' => $passengerData['document_type'],
                    'document_number' => $passengerData['document_number'],
                    'seat' => $passengerData['seat'],
                    'phone' => $passengerData['phone'],
                    'email' => $passengerData['email'],
                ]);

                Log::info('Pasajero creado:', $passenger->toArray());
            }

            DB::commit();

            // Limpiar sesión
            session()->forget('pending_booking');

            Log::info('Pago completado exitosamente. Reserva ID: ' . $booking->id);

            return redirect()->route('bookings.confirmation', ['id' => $booking->id])
                            ->with('success', '¡Pago completado exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en pago: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error en el pago: ' . $e->getMessage());
        }
    }

    public function confirmation($id)
    {
        Log::info('=== CONFIRMACIÓN LLAMADA ===');
        Log::info('ID recibido: ' . $id);
        Log::info('Tipo de ID: ' . gettype($id));

        try {
            $booking = Booking::with('passengers')->find($id);
            
            if (!$booking) {
                Log::error('Reserva no encontrada con ID: ' . $id);
                return redirect()->route('flights.search')
                                ->with('error', 'Reserva no encontrada.');
            }

            Log::info('Reserva encontrada:', $booking->toArray());

            return view('bookings.confirmation', [
                'booking' => $booking
            ]);

        } catch (\Exception $e) {
            Log::error('Error en confirmación: ' . $e->getMessage());
            return redirect()->route('flights.search')
                            ->with('error', 'Error al cargar la confirmación.');
        }
    }

    public function store(Request $request)
    {
        Log::info('Store method called - Datos:', $request->all());

        $request->validate([
            'flight_data' => 'required',
            'passengers_count' => 'required|integer',
            'departure_date' => 'required|date',
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required|string|max:255',
            'passengers.*.last_name' => 'required|string|max:255',
            'passengers.*.second_last_name' => 'required|string|max:255',
            'passengers.*.birth_date' => 'required|date',
            'passengers.*.gender' => 'required|string',
            'passengers.*.document_type' => 'required|string',
            'passengers.*.document_number' => 'required|string|max:50',
            'passengers.*.seat' => 'required|string|max:10',
            'passengers.*.phone' => 'required|string|max:20',
            'passengers.*.email' => 'required|email',
            'terms_accepted' => 'required|accepted'
        ]);

        try {
            DB::beginTransaction();

            $flightData = json_decode($request->flight_data, true);
            $totalPrice = $request->passengers_count * 150000;

            // Crear la reserva
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'flight_number' => $flightData['flight']['number'],
                'airline' => $flightData['airline']['name'],
                'departure_airport' => $flightData['departure']['airport'],
                'arrival_airport' => $flightData['arrival']['airport'],
                'departure_iata' => $flightData['departure']['iata'],
                'arrival_iata' => $flightData['arrival']['iata'],
                'departure_date' => $request->departure_date,
                'departure_time' => $flightData['departure']['scheduled'],
                'arrival_time' => $flightData['arrival']['scheduled'],
                'passengers_count' => $request->passengers_count,
                'total_price' => $totalPrice,
                'booking_status' => 'confirmed',
                'booking_reference' => 'XF' . strtoupper(uniqid()),
                'payment_method' => 'direct', // Método directo sin pasar por pago
                'payment_status' => 'completed',
            ]);

            Log::info('Reserva creada en store:', $booking->toArray());

            // Crear los pasajeros
            foreach ($request->passengers as $passengerData) {
                $passenger = Passenger::create([
                    'booking_id' => $booking->id,
                    'first_name' => $passengerData['first_name'],
                    'second_name' => $passengerData['second_name'] ?? null,
                    'last_name' => $passengerData['last_name'],
                    'second_last_name' => $passengerData['second_last_name'],
                    'birth_date' => $passengerData['birth_date'],
                    'gender' => $passengerData['gender'],
                    'document_type' => $passengerData['document_type'],
                    'document_number' => $passengerData['document_number'],
                    'seat' => $passengerData['seat'],
                    'phone' => $passengerData['phone'],
                    'email' => $passengerData['email'],
                ]);

                Log::info('Pasajero creado en store:', $passenger->toArray());
            }

            DB::commit();

            Log::info('Reserva completada exitosamente en store. ID: ' . $booking->id);

            return redirect()->route('bookings.confirmation', ['id' => $booking->id])
                            ->with('success', '¡Reserva creada exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear reserva en store: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Error al crear la reserva: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Método para simular pasarela de pago (reemplazar con integración real)
    private function processPaymentGateway($method)
    {
        // Simular procesamiento de pago
        sleep(2);
        
        // 95% de éxito en pagos simulados
        return (rand(1, 100) <= 95);
    }
}