<?php

namespace App\Helpers;

use App\Mail\ConfirmacaoReserva;
use App\Models\Hospede;
use App\Models\Reserva;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;

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
        if (!$dtEntrada->gte(Carbon::now()->setTimezone('America/Sao_Paulo')->toDateString())) {
            throw new Exception("Data de entrada deve ser maior ou igual à data atual.");
        }

        if (!$dtSaida->gte($dtEntrada)) {
            throw new Exception("Data de saída deve ser maior ou igual à data de entrada.");
        }

        return;
    }

    /**
     * Envia um email de confirmação de reserva para o hóspede
     * 
     * @param int $idHospede
     * @return void
     */
    public static function enviarConfirmacaoReserva(int $idHospede, Reserva $reserva) 
    {
        $hospede = Hospede::find($idHospede);

        Mail::to($hospede['email'])->send(new ConfirmacaoReserva($hospede['nome'], $reserva));
    }

    /**
     * Verifica se já existe uma reserva entre a data desejada
     * 
     * @param int $idQuarto
     * @param string $dtEntrada - no formado Y-m-d
     * @param string $dtSaida - no formato Y-m-d
     * 
     * @return bool
     */
    public static function existeReservaParaEssaData(
        int $idQuarto, 
        string $dtEntrada, 
        string $dtSaida
    ): bool {
        return Reserva::query()->where('idQuarto', '=', $idQuarto)
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
            )
            ->exists();
    }
}
