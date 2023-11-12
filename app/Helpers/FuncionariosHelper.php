<?php

namespace App\Helpers;

use App\Models\Funcionario;

class FuncionariosHelper
{
    /**
     * Retorna todos os funcionários que fazem parte da governança
     */
    public static function buscarGovernanca(int $idHotel)
    {
        return Funcionario::query()
            ->where("idHotel", "=", $idHotel)
            ->where("tipo", "=", Funcionario::GOVERNANCA)
            ->get();
    }
}