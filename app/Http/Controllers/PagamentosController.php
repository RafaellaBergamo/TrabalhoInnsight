<?php

namespace App\Http\Controllers;

use App\Helpers\PagamentosHelper;
use App\Models\Pagamento;
use Carbon\Carbon;
use Exception;
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
            
            PagamentosHelper::enviarComprovantePorEmail($pagamento['id']);   

            DB::commit();
            return response()->json(["message" => "Pagamento efetuado com sucesso! Um email com os dados do pagamento foi enviado para o email cadastrado."], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
