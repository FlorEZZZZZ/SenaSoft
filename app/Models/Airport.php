<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'city',
        'country'
    ];

    // Vuelos que salen de este aeropuerto
    public function departingFlights()
    {
        return $this->hasMany(Flight::class, 'origin_airport_id');
    }

    // Vuelos que llegan a este aeropuerto
    public function arrivingFlights()
    {
        return $this->hasMany(Flight::class, 'destination_airport_id');
    }
}