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
    public static function quartoDisponivel(
        int $idQuarto,
        string $dtEntrada,
        string $dtSaida
    ): bool {
        $quarto = Quarto::find($idQuarto);
        return !empty($quarto) && (
            $quarto['status'] === Quarto::DISPONIVEL
            || !ReservasHelper::existeReservaParaEssaData($idQuarto, $dtEntrada, $dtSaida)
        );
    }

    /**
     * Retorna a capacidade máxima de hóspedes do quarto
     * 
     * @param int $hotel
     * @param int $idQuarto
     * @return int
     */
    public static function buscarCapacidadeDoQuarto(int $idHotel, int $idQuarto): int
    {
        return Quarto::buscarQuartos($idHotel, $idQuarto)->first()['capacidade'];
    }

    /**
     * Valida se o quarto está disponível e se suporte a quantidade de hóspedes
     * 
     * @param int $idQuarto
     * @param int $idHotel
     * @param int $qtdHospedes
     * @param string $dtEntrada
     * @param string $dtSaida
     * 
     * @return void
     * @throws Exception
     */
    public static function validarQuarto(
        int $idQuarto, 
        int $idHotel, 
        int $qtdHospedes,
        string $dtEntrada,
        string $dtSaida
    ) {
        if (!self::quartoDisponivel($idQuarto, $dtEntrada, $dtSaida)) {
            throw new Exception("Quarto indisponível para essa data.");
        } 

        $capacidadeMaxQuarto = self::buscarCapacidadeDoQuarto($idHotel, $idQuarto);
        if ($qtdHospedes > $capacidadeMaxQuarto) {
            throw new Exception("O quarto suporta apenas {$capacidadeMaxQuarto} hóspedes.");
        }
    }

    /**
     * Retorna os quartos de um hotel que estão com o status enviado
     * 
     * @param int $idHotel
     * @param string $status
     */
    public static function buscarQuartosDoHotelPorStatus(int $idHotel, string $status)
    {
        $estadosPermitidos = [
            'disponiveis' => Quarto::DISPONIVEL,
            'ocupados' => Quarto::OCUPADO,
            'sujos' => Quarto::SUJO,
        ];

        if (!isset($estadosPermitidos[$status])) {
            throw new Exception('Status de quarto inválido.');
        }
        
        return Quarto::query()->where('idHotel', '=', $idHotel)
            ->where('status', '=', $estadosPermitidos[$status])
            ->get();
    }
}