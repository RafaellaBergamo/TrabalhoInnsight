<?php

namespace App\Helpers;

use App\Models\Hotel;
use Exception;

class HoteisHelper
{
    public static function hotelDisponivel(int $idHotel) 
    {
        Reserva::where("idHotel", "=", $idHotel)
            -
        return Quarto::find($idQuarto)['status'] === Quarto::DISPONIVEL;
    }

    public static function buscarCapacidadeHotel(int $idHotel, int $idQuarto)
    {
        return Quarto::buscarQuartos($idHotel, $idQuarto)->first()['capacidade'];
    }

    public static function validarQuarto(int $idQuarto, int $idHotel, int $qtdHospedes) 
    {
        if (!self::quartoDisponivel($idQuarto)) 
        {
            throw new Exception("Quarto indisponível.");
        } 

        $capacidadeMaxQuarto = self::buscarCapacidadeDoQuarto($idHotel, $idQuarto);
        if ($qtdHospedes > $capacidadeMaxQuarto) {
            throw new Exception("O quarto suporta apenas {$capacidadeMaxQuarto} hóspedes.");
        }
    }
}