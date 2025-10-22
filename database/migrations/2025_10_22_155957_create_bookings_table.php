<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanesTable extends Migration
{
    public function up()
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->enum('class', [
                'Avion privado', 
                'Avion Especial', 
                'Avion turbohélice', 
                'Avion Regional', 
                'Avion de fuselaje Estrecho', 
                'Avion de fuselaje ancho'
            ]);
            $table->integer('total_seats');
            $table->json('seat_map'); // Mapa de asientos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('planes');
    }
}
