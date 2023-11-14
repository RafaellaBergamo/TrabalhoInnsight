<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Reserva;
use App\Rules\ValidarData;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagamentosController extends Controller
{
    /**
     * Cadastra uma reserva
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function realizarPagamento(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'idReserva' => 'required|integer',
                'formaPagamento' => 'required|string',
                'dtPagamento' => Carbon::now()
            ]);

            $formaPagamento = $request->input('formaPagamento');
            $dtPagamento = $request->input('dtPagamento');

            if (!Pagamento::formaPagamentoValida($formaPagamento)) {
                throw new Exception("As formas de pagamento permitidas são: BOLETO, CARTAO_CREDITO, CARTA_DEBITO ou DINHEIRO");
            }

            $pagamento = Pagamento::where("idReserva", '=', $request->input('idReserva'));

            if (empty(count($pagamento))) {
                throw new Exception("Pagamento não pode ser efetuado. Por favor, verifique se o id da reserva está correto.");
            }

            $pagamento->update([
                'formaPagamento' => $formaPagamento,
                'dtPagamento' => $dtPagamento
            ]);

            DB::commit();
            return response()->json(["message" => "Reserva cadastrada com sucesso! Um email com os dados da reserva foi enviado para o email cadastrado."], 201);
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
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        } finally {
            DB::closeConnection();
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
