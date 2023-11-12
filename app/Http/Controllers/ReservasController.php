<?php

namespace App\Http\Controllers;

use App\Helpers\HoteisHelper;
use App\Helpers\QuartosHelper;
use App\Helpers\ReservasHelper;
use App\Models\Reserva;
use App\Rules\ValidarData;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    public function cadastrarReserva(Request $request) 
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer', 
                'idHospede' => 'required|integer',
                'idQuarto' => 'required|integer',
                'qtdHospedes' => 'required|integer',
                'dtEntrada' => ['required', new ValidarData],
                'dtSaida' => ['required', new ValidarData],
                'vlReserva' => 'required|numeric'
            ]);

            $dtEntrada = Carbon::createFromFormat('d/m/Y', $request->input('dtEntrada'))->timezone('America/Sao_Paulo');
            $dtSaida =  Carbon::createFromFormat('d/m/Y', $request->input('dtSaida'))->timezone('America/Sao_Paulo');

            $idQuarto = $request->input('idQuarto');
            $idHotel = $request->input('idHotel');
            $qtdHospedes = $request->input('qtdHospedes');

            HoteisHelper::hotelDisponivel($idHotel);
            QuartosHelper::validarQuarto($idQuarto, $idHotel, $qtdHospedes);
            ReservasHelper::validarCamposDeData($dtEntrada, $dtSaida);

            $request->merge([
                'dtEntrada' => Carbon::createFromFormat('Y-m-d H:i:s', $dtEntrada),
                'dtSaida' => Carbon::createFromFormat('Y-m-d H:i:s', $dtSaida)
            ]);


            Reserva::create($request->all());

            return response()->json(["message" => "Reserva cadastrada com sucesso!"], 201);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function buscarReserva(int $idReserva) 
    {
        try {
            $reserva = Reserva::where("idReserva", "=", $idReserva);
    
            if (empty($reserva)) {
                return response()->json(['message' => 'Reserva não encontrada.'], 404);
            }
    
            return response()->json($reserva);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

}
