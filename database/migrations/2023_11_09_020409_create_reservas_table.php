<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idHotel');
            $table->unsignedBigInteger('idHospede');
            $table->unsignedBigInteger('idQuarto');
            $table->unsignedBigInteger('idRegistro');
            $table->date('dtEntrada');
            $table->date('dtSaida');
            $table->float('vlReserva');
            $table->timestamps();
        });

        Schema::table('reservas', function (Blueprint $table) {
            $table->foreign('idHotel')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('idHospede')->references('id')->on('hospedes')->onDelete('cascade');
            $table->foreign('idQuarto')->references('id')->on('quartos')->onDelete('cascade');
            $table->foreign('idRegistro')->references('id')->on('registro_hospedes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
