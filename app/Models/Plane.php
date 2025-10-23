<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'class',
        'total_seats',
        'seat_map'
    ];

    protected $casts = [
        'seat_map' => 'array'
    ];

    // Vuelos de este avión
    public function flights()
    {
        return $this->hasMany(Flight::class, 'plane_id');
    }
}