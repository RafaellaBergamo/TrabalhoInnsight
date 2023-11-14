<?php

namespace App\Helpers;

use App\Models\Quarto;
use Exception;

class QuartosHelper
{
    /**
     * Retorna se o quarto está disponível
     * 
     * @param int $idQuarto
     * @return bool
     */
    public static function quartoDisponivel(int $idQuarto): bool 
    {
        return Quarto::find($idQuarto)['status'] === Quarto::DISPONIVEL;
    }

    /**
     * Retorna a capacidade máxima de hóspedes do quarto
     * 
     * @param int $hotel
     * @param int $idQuarto
     * @return int
     */
    public static function buscarCapacidadeDoQuarto(int $idHotel, int $idQuarto):int
    {
        return Quarto::buscarQuartos($idHotel, $idQuarto)->first()['capacidade'];
    }

    /**
     * Valida se o quarto está disponível e se suporte a quantidade de hóspedes
     * 
     * @param int $idQuarto
     * @param int $idHotel
     * @param int $qtdHospedes
     * 
     * @return void
     * @throws Exception
     */
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