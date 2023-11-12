<?php

namespace App\Helpers;


use Carbon\Carbon;
use Exception;

class ReservasHelper
{
    /**
     * Valida se as datas de entrada e saída da reserva estão corretas
     * 
     * @param Carbon $dtEntrada
     * @param Carbon $dtSaida
     * 
     * @return void
     */
    public static function validarCamposDeData(Carbon $dtEntrada, Carbon $dtSaida)
    {

        if (!$dtEntrada->gte(Carbon::today())) {
            throw new Exception("Data de entrada deve ser maior ou igual à data atual.");
        }

        if (!$dtSaida->gte($dtEntrada)) {
            throw new Exception("Data de saída deve ser maior ou igual à data de entrada.");
        }

        return;
    }
}
