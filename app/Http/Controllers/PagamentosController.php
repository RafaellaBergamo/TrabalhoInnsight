<?php

namespace App\Http\Controllers;

use App\Helpers\PagamentosHelper;
use App\Models\Pagamento;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
                'formaPagamento' => 'required|string'
            ]);

            $pagamento = Pagamento::query()->where("idReserva", '=', $request->input('idReserva'))->first();

            if (empty($pagamento)) {
                throw new Exception("Pagamento não pode ser efetuado. Por favor, verifique se o id da reserva está correto.");
            }

            $formaPagamento = $request->input('formaPagamento');

            if (!Pagamento::formaPagamentoValida($formaPagamento)) {
                throw new Exception("As formas de pagamento permitidas são: BOLETO, CARTAO_CREDITO, CARTAO_DEBITO ou DINHEIRO");
            }

            $request->merge([
                'dtPagamento' => Carbon::now(),
                'formaPagamento' => PagamentosHelper::normalizarFormaPagamento($formaPagamento)
            ]);

            $pagamento->update($request->all());                                                                                                                                                                                                           
            
            PagamentosHelper::enviarComprovantePorEmail($pagamento['id'], $formaPagamento);   

            DB::commit();
            return response()->json(["message" => "Pagamento efetuado com sucesso! Um email com os dados do pagamento foi enviado para o email cadastrado."], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna os dados de pagamento
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function buscarDadosPagamento(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'idPagamento' => 'integer',
                'idHospede' => 'integer',
                'idReserva' => 'integer'
            ]);

            $idPagamento = $request->input('idPagamento');
            $idHospede = $request->input('idHospede');
            $idReserva = $request->input('idReserva');

            $pagamentos = PagamentosHelper::buscarDadosPagamento($idPagamento, $idHospede, $idReserva);

            return response()->json(["data" => $pagamentos], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
