<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function search()
    {
        return view('flights.search');
    }

    public function searchFlights(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string|different:origin',
            'departure_date' => 'required|date',
            'passengers' => 'required|integer|min:1|max:5'
        ]);

        try {
            $outboundFlights = Flight::with(['originAirport', 'destinationAirport', 'plane'])
                ->where('available_seats', '>=', $request->passengers)
                ->where('status', 'scheduled')
                ->get();

            return view('flights.search-results', [
                'outboundFlights' => $outboundFlights,
                'returnFlights' => collect(),
                'request' => $request
            ]);

        } catch (\Exception $e) {
            return $this->showSampleResults($request);
        }
    }

    public function showSearchResults(Request $request)
    {
        $outboundFlights = Flight::with(['originAirport', 'destinationAirport', 'plane'])
            ->where('available_seats', '>', 0)
            ->where('status', 'scheduled')
            ->limit(5)
            ->get();

        return view('flights.search-results', [
            'outboundFlights' => $outboundFlights,
            'returnFlights' => collect(),
            'request' => $request
        ]);
    }

    private function showSampleResults($request)
    {
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
            ]
        ];

        return view('flights.search-results', [
            'outboundFlights' => collect($sampleFlights),
            'returnFlights' => collect(),
            'request' => $request
        ]);
    }

    public function show($id)
    {
        try {
            $flight = Flight::with(['originAirport', 'destinationAirport', 'plane'])->findOrFail($id);
            return view('flights.show', ['flight' => $flight]);
        } catch (\Exception $e) {
            return redirect()->route('flights.search')->with('error', 'Vuelo no encontrado.');
        }
    }

    public function getAirports(Request $request)
    {
        $query = $request->get('query');
        
        try {
            if (strlen($query) < 2) return response()->json([]);
            
            $airports = Airport::where('city', 'like', "%{$query}%")
                ->orWhere('name', 'like', "%{$query}%")
                ->orWhere('code', 'like', "%{$query}%")
                ->limit(10)
                ->get(['id', 'code', 'name', 'city', 'country']);

            return response()->json($airports);
        } catch (\Exception $e) {
            $sampleAirports = [
                ['id' => 1, 'code' => 'BOG', 'name' => 'Aeropuerto El Dorado', 'city' => 'Bogotá', 'country' => 'Colombia'],
                ['id' => 2, 'code' => 'MDE', 'name' => 'Aeropuerto José María Córdova', 'city' => 'Medellín', 'country' => 'Colombia'],
            ];

            $filtered = array_filter($sampleAirports, function($airport) use ($query) {
                return stripos($airport['city'], $query) !== false || 
                       stripos($airport['code'], $query) !== false;
            });

            return response()->json(array_values($filtered));
        }
    }
}