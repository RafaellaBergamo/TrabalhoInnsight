<?php

namespace App\Http\Controllers;

use App\Helpers\QuartosHelper;
use App\Helpers\ReservasHelper;
use App\Models\Reserva;
use App\Rules\ValidarData;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    /**
     * Cadastra uma reserva
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function cadastrarReserva(Request $request): JsonResponse
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

    /**
     * Atualiza uma reserva
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function atualizarReserva(Request $request) 
    {
        try {
            $request->validate([
                'idReserva' => 'required|integer',
                'idHotel' => 'integer', 
                'idHospede' => 'integer',
                'idQuarto' => 'integer',
                'qtdHospedes' => 'integer',
                'dtEntrada' => new ValidarData,
                'dtSaida' => new ValidarData,
                'vlReserva' => 'numeric'
            ]);


            $idReserva = $request->input('idReserva');

            $reserva = Reserva::findOrFail($idReserva);

            $reserva->update($request->all());

            return response()->json([
                "message" => "Reserva atualizada com sucesso!", 
                "data" => $reserva
            ]);

        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Reserva não encontrada.'], 404);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca uma reserva por id
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function buscarReserva(int $idReserva) 
    {
        try {
            $reserva = Reserva::findOrFail($idReserva);
    
            return response()->json($reserva);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => "Reserva não encontrada"], 500);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

}
