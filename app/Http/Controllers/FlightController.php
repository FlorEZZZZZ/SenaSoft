<?php
// app/Http/Controllers/FlightController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlightController extends Controller
{
    public function showSearchForm()
    {
        return view('flights.search', [
            'defaultDate' => date('Y-m-d')
        ]);
    }

    public function searchFlights(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|size:3',
            'destination' => 'required|string|size:3',
            'departure_date' => 'required|date',
            'passengers' => 'required|integer|min:1|max:5'
        ]);

        try {
            $apiKey = '4fb3904de724e89045866c173acbba84';
            
            \Log::info('Buscando vuelos:', $request->all());

            $response = Http::timeout(30)->get('http://api.aviationstack.com/v1/flights', [
    'access_key' => $apiKey,
    'dep_iata' => strtoupper($request->origin),
    'arr_iata' => strtoupper($request->destination),
    // 'flight_date' => $request->departure_date, // Comenta esta línea
    'limit' => 10
]);

            $data = $response->json();
            \Log::info('Respuesta API:', $data);

            if (isset($data['data']) && count($data['data']) > 0) {
                $flights = $data['data'];
                
                return view('flights.search', [
                    'flights' => $flights,
                    'searchParams' => $request->all(),
                    'defaultDate' => $request->departure_date
                ])->with('success', 'Se encontraron ' . count($flights) . ' vuelos.');
            } else {
                \Log::warning('No se encontraron vuelos para:', $request->all());
                return view('flights.search', [
                    'flights' => [],
                    'searchParams' => $request->all(),
                    'defaultDate' => $request->departure_date
                ])->with('error', 'No se encontraron vuelos para esta ruta y fecha. Intenta con otra combinación.');
            }

        } catch (\Exception $e) {
            \Log::error('Error API Aviation Stack: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al conectar con el servicio de vuelos. Intenta nuevamente.')
                ->withInput();
        }
    }
}