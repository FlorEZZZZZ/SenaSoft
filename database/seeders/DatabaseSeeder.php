<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba
        User::create([
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'phone' => '3001234567'
        ]);

        // Ejecutar otros seeders
        $this->call([
            AirportSeeder::class,
            PlaneSeeder::class,
            FlightSeeder::class,
        ]);
    }
}