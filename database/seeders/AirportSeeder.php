<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airport;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $airports = [
            ['code' => 'BOG', 'name' => 'Aeropuerto Internacional El Dorado', 'city' => 'Bogotá', 'country' => 'Colombia'],
            ['code' => 'MDE', 'name' => 'Aeropuerto Internacional José María Córdova', 'city' => 'Medellín', 'country' => 'Colombia'],
            ['code' => 'CLO', 'name' => 'Aeropuerto Internacional Alfonso Bonilla Aragón', 'city' => 'Cali', 'country' => 'Colombia'],
            ['code' => 'BAQ', 'name' => 'Aeropuerto Internacional Ernesto Cortissoz', 'city' => 'Barranquilla', 'country' => 'Colombia'],
            ['code' => 'CTG', 'name' => 'Aeropuerto Internacional Rafael Núñez', 'city' => 'Cartagena', 'country' => 'Colombia'],
        ];

        foreach ($airports as $airport) {
            Airport::create($airport);
        }
    }
}