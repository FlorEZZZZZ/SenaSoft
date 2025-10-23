<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Flight;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $flights = [
            [
                'flight_number' => 'XF100',
                'plane_id' => 1,
                'origin_airport_id' => 1, // BOG
                'destination_airport_id' => 2, // MDE
                'departure_time' => Carbon::now()->addDays(1)->setHour(8)->setMinute(0),
                'arrival_time' => Carbon::now()->addDays(1)->setHour(9)->setMinute(0),
                'price' => 250000,
                'available_seats' => 180,
                'status' => 'scheduled'
            ],
            [
                'flight_number' => 'XF101', 
                'plane_id' => 2,
                'origin_airport_id' => 2, // MDE
                'destination_airport_id' => 1, // BOG
                'departure_time' => Carbon::now()->addDays(1)->setHour(10)->setMinute(0),
                'arrival_time' => Carbon::now()->addDays(1)->setHour(11)->setMinute(0),
                'price' => 230000,
                'available_seats' => 160,
                'status' => 'scheduled'
            ],
            [
                'flight_number' => 'XF200',
                'plane_id' => 1,
                'origin_airport_id' => 1, // BOG
                'destination_airport_id' => 3, // CLO
                'departure_time' => Carbon::now()->addDays(2)->setHour(14)->setMinute(0),
                'arrival_time' => Carbon::now()->addDays(2)->setHour(15)->setMinute(30),
                'price' => 300000,
                'available_seats' => 180,
                'status' => 'scheduled'
            ]
        ];

        foreach ($flights as $flight) {
            Flight::create($flight);
        }
    }
}