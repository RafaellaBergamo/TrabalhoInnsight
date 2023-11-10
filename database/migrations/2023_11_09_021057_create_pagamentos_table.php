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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idHospede');
            $table->unsignedBigInteger('idReserva');
            $table->date("dtPagamento")->nullable();
            $table->integer('formaPagamento');
            $table->timestamps();
        });

        Schema::table('pagamentos', function (Blueprint $table) {
            $table->foreign('idHospede')->references('id')->on('hospedes')->onDelete('cascade');
            $table->foreign('idReserva')->references('id')->on('reservas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
