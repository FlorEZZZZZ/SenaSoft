<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('flight_number');
            $table->string('airline');
            $table->string('departure_airport');
            $table->string('arrival_airport');
            $table->string('departure_iata', 3);
            $table->string('arrival_iata', 3);
            $table->date('departure_date');
            $table->datetime('departure_time');
            $table->datetime('arrival_time');
            $table->integer('passengers_count');
            $table->decimal('total_price', 10, 2);
            $table->string('booking_status')->default('confirmed');
            $table->string('booking_reference')->unique();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}