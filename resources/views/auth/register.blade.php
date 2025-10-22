<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - X-Fly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class ></nav>
</body>
</html>

<?php
// database/migrations/2024_01_01_create_vuelos_table.php
public function up()
{
    Schema::create('vuelos', function (Blueprint $table) {
        $table->id();
        $table->string('codigo_vuelo'); // XF100
        $table->string('aerolinea'); // Avianca, Latam, etc
        $table->string('origen'); // BOG
        $table->string('destino'); // MDE
        $table->dateTime('salida');
        $table->dateTime('llegada');
        $table->integer('duracion'); // minutos
        $table->decimal('precio_economy', 10, 2);
        $table->decimal('precio_business', 10, 2);
        $table->integer('asientos_disponibles');
        $table->json('asientos_ocupados')->nullable();
        $table->string('estado'); // activo, cancelado, completado
        $table->timestamps();
    });
}

// database/migrations/2024_01_02_create_reservas_table.php
public function up()
{
    Schema::create('reservas', function (Blueprint $table) {
        $table->id();
        $table->string('codigo_reserva')->unique();
        $table->foreignId('vuelo_id')->constrained('vuelos');
        $table->string('external_booking_id'); // ID de la API de aerolínea
        $table->json('datos_pasajeros');
        $table->json('asientos_seleccionados');
        $table->decimal('total', 10, 2);
        $table->string('estado'); // pendiente, confirmada, cancelada
        $table->string('metodo_pago')->nullable();
        $table->timestamps();
    });
}