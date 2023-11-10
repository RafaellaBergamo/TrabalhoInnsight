<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Funcionario;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('cpf');
            $table->boolean('status')->default(Funcionario::STATUS_ATIVO);
            $table->integer('tipo')->default(Funcionario::COMUM);
            $table->unsignedBigInteger('idHotel');
            $table->timestamps();
        });

        Schema::table('funcionarios', function (Blueprint $table) {
            $table->foreign('idHotel')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
