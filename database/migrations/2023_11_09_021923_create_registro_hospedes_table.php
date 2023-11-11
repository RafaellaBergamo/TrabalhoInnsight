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
        Schema::create('registro_hospedes', function (Blueprint $table) {
            $table->id();
            $table->date('dtCheckin');
            $table->date('dtCheckout')->nullable();
            $table->unsignedBigInteger('idReserva');
            $table->timestamps();
        });

        Schema::table('registro_hospedes', function (Blueprint $table) {
            $table->foreign('idReserva')->references('id')->on('reservas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_hospedes');
    }
};
