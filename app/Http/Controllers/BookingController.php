<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $flight = (object)[
            'id' => 1,
            'flight_number' => 'XF100',
            'origin' => 'Bogotá (BOG)',
            'destination' => 'Medellín (MDE)',
            'departure_date' => now()->addDay()->format('d/m/Y'),
            'departure_time' => '08:00',
            'arrival_time' => '09:00',
            'price' => 250000
        ];

        return view('bookings.create', compact('flight'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'passengers' => 'required|array|min:1|max:5',
            'passengers.*.first_name' => 'required|string|max:255',
            'passengers.*.last_name' => 'required|string|max:255',
            'passengers.*.document_type' => 'required|string',
            'passengers.*.document_number' => 'required|string',
            'passengers.*.email' => 'required|email',
            'passengers.*.phone' => 'required|string',
            'terms_accepted' => 'required|accepted'
        ]);

        try {
            $bookingData = [
                'id' => rand(1000, 9999),
                'booking_code' => 'XF' . strtoupper(uniqid()),
                'total_amount' => 250000 * count($request->passengers),
                'passengers' => $request->passengers,
                'flight' => [
                    'number' => 'XF100',
                    'route' => 'Bogotá (BOG) - Medellín (MDE)',
                    'date' => now()->addDay()->format('d/m/Y'),
                    'time' => '08:00 - 09:00'
                ]
            ];

            session(['current_booking' => $bookingData]);

            return redirect()->route('bookings.payment')->with('success', 'Reserva creada exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear la reserva.')->withInput();
        }
    }

    public function index()
    {
        return view('bookings.index');
    }

    public function show($id)
    {
        return view('bookings.show', ['bookingId' => $id]);
    }

    public function downloadTicket($id)
    {
        return response()->download(public_path('tickets/ticket-' . $id . '.pdf'));
    }
}