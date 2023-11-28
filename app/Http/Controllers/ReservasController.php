<?php

namespace App\Http\Controllers;

use App\Helpers\HoteisHelper;
use App\Helpers\QuartosHelper;
use App\Helpers\ReservasHelper;
use App\Models\Pagamento;
use App\Models\Reserva;
use App\Rules\ValidarData;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
            DB::beginTransaction();
            
            $request->validate([
                'idHotel' => 'required|integer', 
                'idHospede' => 'required|integer',
                'idQuarto' => 'required|integer',
                'qtdHospedes' => 'required|integer',
                'dtEntrada' => ['required', new ValidarData],
                'dtSaida' => ['required', new ValidarData],
                'vlReserva' => 'required|numeric'
            ]);

            $dtEntrada = Carbon::createFromFormat('d/m/Y', $request->input('dtEntrada'), 'America/Sao_Paulo');
            $dtSaida =  Carbon::createFromFormat('d/m/Y', $request->input('dtSaida'), 'America/Sao_Paulo');

            $idQuarto = $request->input('idQuarto');
            $idHotel = $request->input('idHotel');
            $qtdHospedes = $request->input('qtdHospedes');
            $idHospede = $request->input('idHospede');

            if (HoteisHelper::hotelEmCapacidadeMáxima(
                $idHotel,
                $dtEntrada->format('Y-m-d'),
                $dtSaida->format('Y-m-d')
            )) {
                $idHotelDisponivel = HoteisHelper::buscarHotelDisponivel($dtEntrada->format('Y-m-d'), $dtSaida->format('Y-m-d'));

                if (empty($idHotelDisponivel)) {
                    throw new Exception("Nenhum hotel disponível para essa data.");
                }

                throw new Exception("O hotel escolhido não está disponível para essa data. Sugerimos reservar no hotel {$idHotelDisponivel}");
            };

            QuartosHelper::validarQuarto(
                $idQuarto, 
                $idHotel, 
                $qtdHospedes,
                $dtEntrada->format('Y-m-d'),
                $dtSaida->format('Y-m-d')
            );

            ReservasHelper::validarCamposDeData($dtEntrada, $dtSaida);

            $request->merge([
                'dtEntrada' => Carbon::createFromFormat('Y-m-d H:i:s', $dtEntrada),
                'dtSaida' => Carbon::createFromFormat('Y-m-d H:i:s', $dtSaida)
            ]);

            $reserva = Reserva::create($request->all());

            Pagamento::gerarPagamentoPendente($reserva['idHospede'], $reserva['id']);
            ReservasHelper::enviarConfirmacaoReserva($idHospede, $reserva);

            DB::commit();

            return response()->json(["message" => "Reserva cadastrada com sucesso! Um email com os dados da reserva foi enviado para o email cadastrado.", "data" => $reserva->id], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
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
            DB::beginTransaction();

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

            DB::commit();
            return response()->json([
                "message" => "Reserva atualizada com sucesso!", 
                "data" => $reserva
            ]);

        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Reserva não encontrada.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
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

    /**
     * Busca as reservas de um hóspede
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function buscarReservasDoHospede(Request $request) 
    {
        try {
            $request->validate([
                'idHospede' => 'required|integer'
            ]);

            $idHospede = $request->input('idHospede');
            $reserva = Reserva::where('idHospede', '=', $idHospede);

            return response()->json($reserva);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
