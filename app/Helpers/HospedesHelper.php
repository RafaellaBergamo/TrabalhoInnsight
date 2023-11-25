<?php

namespace App\Helpers;

use App\Models\Hospede;
use Exception;

class HospedesHelper
{
    /**
     * Retorna todos os hóspedes que estão hospedados no hotel informado
     * 
     * @param int $idHotel
     * @return array
     */
    public static function buscarHospedesDoHotel(int $idHotel): array
    {
        return Hospede::join('reservas', 'reservas.idHospede', '=', 'hospedes.id')
            ->join('registro_hospedes', 'registro_hospedes.idReserva', '=', 'reservas.id')
            ->select('hospedes.id', 'hospedes.nome', 'reservas.dtEntrada', 'reservas.dtSaida', 'reservas.vlReserva')
            ->whereNull('registro_hospedes.dtCheckout')
            ->where('reservas.dtSaida', '>', today('America/Sao_Paulo'))
            ->where('reservas.idHotel', '=', $idHotel)
            ->get()
            ->toArray();
    }
}