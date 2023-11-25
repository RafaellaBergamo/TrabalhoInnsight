<?php

namespace App\Helpers;

use App\Models\Hotel;
use App\Models\Reserva;
use Exception;

class HoteisHelper
{
    /**
     * Retorna se o hotel escolhido já está com a capacidade máxima ocupada
     * 
     * @param int $idHotel
     * @param string $dtEntrada Y-m-d
     * @param string $dtSaida Y-m-d
     * 
     * @return bool
     */
    public static function hotelEmCapacidadeMáxima(
        int $idHotel, 
        string $dtEntrada, 
        string $dtSaida
    ): bool {
        $reservas = Reserva::query()->where('idHotel', '=', $idHotel)
            ->where(
            function ($query) use ($dtEntrada, $dtSaida) {
                $query->whereBetween('dtEntrada', [$dtEntrada, $dtSaida])
                    ->orWhereBetween('dtSaida', [$dtEntrada, $dtSaida])
                    ->orWhere(
                        function ($query) use ($dtEntrada, $dtSaida) {
                            $query->where('dtEntrada', '<=', $dtEntrada)
                            ->where('dtSaida', '>=', $dtSaida);
                        }
                    );
            }       
        )->get();

        $capacidadeHotel = Hotel::find($idHotel)['qtdQuartos'];

        return $capacidadeHotel == count($reservas);
    }

    /**
     * Busca o próximo hotel disponível para reservas
     * 
     * @param string $dtEntrada Y-m-d
     * @param string $dtSaida Y-m-d
     * 
     * @return int|null
     */
    public static function buscarHotelDisponivel(string $dtEntrada, string $dtSaida)
    {
        $hoteis = Hotel::all();

        foreach ($hoteis as $hotel) {
            $idHotel = $hotel->id;
    
            if (!self::hotelEmCapacidadeMáxima($idHotel, $dtEntrada, $dtSaida)) {
                return (int) $hotel->id; 
            }
        }

        return null;
    }
}