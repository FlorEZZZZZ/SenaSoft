<?php
// app/Models/Passenger.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'first_name',
        'second_name',
        'last_name',
        'second_last_name',
        'birth_date',
        'gender',
        'document_type',
        'document_number',
        'seat',
        'phone',
        'email',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}