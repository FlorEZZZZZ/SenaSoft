<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'plane_id',
        'origin_airport_id',
        'destination_airport_id',
        'departure_time',
        'arrival_time',
        'price',
        'available_seats',
        'status',
        'has_delay',
        'delay_reason'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    // CORREGIDO: Relación con el aeropuerto de origen
    public function originAirport()
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    // CORREGIDO: Relación con el aeropuerto de destino
    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }

    // Relación con el avión
    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    // Relación con reservas
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Método para obtener asientos ocupados
    public function getOccupiedSeats()
    {
        try {
            return $this->bookings()
                ->whereIn('status', ['confirmed', 'completed'])
                ->with('passengers')
                ->get()
                ->pluck('passengers')
                ->flatten()
                ->pluck('seat_number')
                ->filter()
                ->toArray();
        } catch (\Exception $e) {
            return []; // Retornar array vacío si hay error
        }
    }

    // Método para verificar disponibilidad
    public function isAvailableFor($passengers)
    {
        return $this->available_seats >= $passengers && $this->status === 'scheduled';
    }
}