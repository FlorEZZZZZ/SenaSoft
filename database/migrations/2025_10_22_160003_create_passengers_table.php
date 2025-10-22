<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->enum('gender', ['Hombre', 'Mujer', 'Otro']);
            $table->string('other_gender')->nullable();
            $table->enum('document_type', [
                'Registro civil', 
                'Tarjeta de identidad', 
                'Cedula de Ciudadania', 
                'Cedula de Extranjeria', 
                'Tarjeta de Extranjeria', 
                'Pasaporte', 
                'Carné Diplomático', 
                'Permiso Especial de Permanencia'
            ]);
            $table->string('document_number');
            $table->boolean('is_infant')->default(false);
            $table->string('phone');
            $table->string('email');
            $table->string('seat_number')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('passengers');
    }
}
