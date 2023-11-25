<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Quarto;
use App\Models\RegistroHospede;
use App\Models\Reserva;
use App\Rules\ApenasNumeros;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrosHospedesController extends Controller
{
    /**
     * Registra um checkin
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function registrarCheckin(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'idReserva' => ['required', new ApenasNumeros]
            ]);

            $idReserva = $request->input('idReserva');

            $request->merge([
                'dtCheckin' => Carbon::now()
            ]);

            $reserva =  Reserva::where('id', '=', $idReserva)->first();

            if (empty($reserva)) {
                throw new Exception("Reserva não encontrada. Verifique se a o id da reserva está correto.");
            }

            if (!empty($registro['dtCheckin'])) {
                throw new Exception("Checkin já realizado anteriormente.");
            }

            RegistroHospede::create($request->all());

            Quarto::atualizarDadosQuarto(
                $reserva['idQuarto'],
                $reserva['idHotel'], 
                ['status' => Quarto::OCUPADO]
            );
            
            DB::commit();
            return response()->json(["message" => "Checkin efetuado com sucesso!"], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

        /**
     * Registra um checkin
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function registrarCheckout(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'idReserva' => ['required', new ApenasNumeros]
            ]);

            $request->merge([
                'dtCheckout' => Carbon::now()
            ]);

            $idReserva = $request->input('idReserva');

            $registro = RegistroHospede::query()->where('idReserva', '=', $idReserva)->first();

            if (empty($registro)) {
                throw new Exception("Reserva não encontrada. Verifique se a o id da reserva está correto.");
            }

            if (!empty($registro['dtCheckout'])) {
                throw new Exception("Checkout já realizado anteriormente.");
            }

            if (empty($registro['dtCheckin'])) {
                throw new Exception("Você deve realizar o checkin antes de fazer checkout.");
            }

            if (Pagamento::pagamentoPendente($idReserva)) {
                throw new Exception("Você deve realizar o pagamento da reserva antes do checkout!");
            }

            $registro->update($request->all());
            
            DB::commit();
            return response()->json(["message" => "Checkout efetuado com sucesso!"], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }
}