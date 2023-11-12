<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Rules\ApenasNumeros;
use App\Rules\CpfCnpjUnico;
use App\Rules\ValidarCpfCnpj;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FuncionariosController extends Controller
{
    /**
     * Cadastra uma funcionário
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function cadastrarFuncionario(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nome' => 'required|string',
                'cpf' => ['numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'tipo' => 'integer',
                'email' => 'required|email'
            ]);

            Funcionario::create($request->all());
    
            return response()->json(["message" => "Funcionário cadastrado com sucesso!"], 201);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Atualiza um funcionário
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function atualizarFuncionario(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'idFuncionario' => 'required',
                'nome' => 'string', 
                'cpf' => ['numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'status' => 'integer',
                'tipo' => 'integer',
                'email' => 'email'
            ]);

            $idFuncionario = $request->input('idFuncionario');

            $funcionario = Funcionario::findOrFail($idFuncionario);

            $funcionario->update($request->all());

            return response()->json([
                "message" => "Funcionário atualizado com sucesso!",
                "data" => $funcionario
            ]);

        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Funcionário não encontrado.'], 404);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca um funcionário por id
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function buscarFuncionario(int $idFuncionario): JsonResponse
    {
        try {
            $idFuncionario = Funcionario::findOrFail($idFuncionario);
    
            return response()->json($idFuncionario);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => "Funcionário não encontrada"], 500);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca funcionários de um hotel
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function buscarFuncionariosDoHotel(int $idHotel): JsonResponse
    {
        try {
            $funcionarios = Funcionario::where("idHotel", "=", $idHotel)->get();
    
            if (empty(count($funcionarios))) {
                return response()->json(['errors' => "Esse hotel não possui funcionários."], 500);
            }

            return response()->json($funcionarios);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
