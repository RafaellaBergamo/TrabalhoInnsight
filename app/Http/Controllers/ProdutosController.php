<?php

namespace App\Http\Controllers;

use App\Helpers\FuncionariosHelper;
use App\Models\Funcionario;
use App\Models\Hotel;
use App\Models\Produto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProdutosController extends Controller
{
    /**
     * Cadastra um produto
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function cadastrarProduto(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'emailFuncionario' => 'required|email',
                'senhaFuncionario' => 'required|string',
                'idHotel' => 'required|integer',
                'descricao' => 'required|string',
                'quantidade' => 'required|integer|min:0'
            ]);

            $email = $request->input('emailFuncionario');
            $senha = $request->input('senhaFuncionario');

            if (!FuncionariosHelper::funcionarioComAcesso($email, $senha, [Funcionario::GOVERNANCA, Funcionario::MASTER])) {
                throw new Exception("Funcionário sem acesso.");
            }

            Hotel::findOrFail($request->input('idHotel'));

            Produto::create($request->all());

            DB::commit();

            return response()->json(["message" => "Produto cadastrado com sucesso!"], 201);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            return response()->json(['errors' => 'Hotel não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Atualiza um produto
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function atualizarEstoque(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'emailFuncionario' => 'required|email',
                'senhaFuncionario' => 'required|string',
                'idProduto' => 'required|integer',
                'descricao' => 'required|string',
                'quantidade' => 'required|integer|min:0'
            ]);

            $email = $request->input('emailFuncionario');
            $senha = $request->input('senhaFuncionario');

            if (!FuncionariosHelper::funcionarioComAcesso($email, $senha, [Funcionario::GOVERNANCA, Funcionario::MASTER])) {
                throw new Exception("Funcionário sem acesso.");
            }

            $idProduto = $request->input('idProduto');

            $produto = Produto::findOrFail($idProduto);

            $produto->update($request->all());

            DB::commit();

            return response()->json([
                "message" => "Estoque atualizado com sucesso!",
                "data" => $produto
            ]);

        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            return response()->json(['errors' => 'Produto não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca produtos pelo hotel, id do produto ou descrição
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function buscarProdutos(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'emailFuncionario' => 'required|email',
                'senhaFuncionario' => 'required|string',
                'idHotel' => 'integer',
                'idProduto' => 'integer',
                'descricao' => 'string',
            ]);

            $email = $request->input('emailFuncionario');
            $senha = $request->input('senhaFuncionario');

            if (!FuncionariosHelper::funcionarioComAcesso($email, $senha, [Funcionario::GOVERNANCA, Funcionario::MASTER])) {
                throw new Exception("Funcionário sem acesso.");
            }

            $idHotel = $request->input('idHotel');
            $idProduto = $request->input('idProduto');
            $descricao = $request->input('descricao');

            $queryBuscarProduto = Produto::query()
                ->when(!empty($idProduto), function ($query) use ($idProduto) {
                    $query->where('id', '=', $idProduto);
                })
                ->when(!empty($idHotel), function ($query) use ($idHotel) {
                    $query->where('idHotel', '=', $idHotel);
                })
                ->when(!empty($descricao), function ($query) use ($descricao) {
                    $query->where('descricao', 'LIKE', "%{$descricao}%");
                });

            $produtos = $queryBuscarProduto->get();


            return response()->json(["data" => $produtos]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
