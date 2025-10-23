<?php
// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_number',
        'airline',
        'departure_airport',
        'arrival_airport',
        'departure_iata',
        'arrival_iata',
        'departure_date',
        'departure_time',
        'arrival_time',
        'passengers_count',
        'total_price',
        'booking_status',
        'booking_reference',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}