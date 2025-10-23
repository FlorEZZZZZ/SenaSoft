<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plane;

class PlaneSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            [
                'model' => 'Airbus A320',
                'class' => 'Avion de fuselaje Estrecho',
                'total_seats' => 180,
                'seat_map' => json_encode([
                    'rows' => 30,
                    'seats_per_row' => 6,
                    'layout' => '3-3',
                    'seats' => $this->generateSeats(30, 6, ['A', 'B', 'C', 'D', 'E', 'F'])
                ])
            ],
            [
                'model' => 'Boeing 737',
                'class' => 'Avion de fuselaje Estrecho', 
                'total_seats' => 160,
                'seat_map' => json_encode([
                    'rows' => 26,
                    'seats_per_row' => 6,
                    'layout' => '3-3',
                    'seats' => $this->generateSeats(26, 6, ['A', 'B', 'C', 'D', 'E', 'F'])
                ])
            ],
        ];

        foreach ($planes as $plane) {
            Plane::create($plane);
        }
    }

    private function generateSeats($rows, $seatsPerRow, $letters)
    {
        $seats = [];
        for ($row = 1; $row <= $rows; $row++) {
            for ($seat = 0; $seat < $seatsPerRow; $seat++) {
                $seats[] = $row . $letters[$seat];
            }
        }
        return $seats;
    }
}