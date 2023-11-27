<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Hotel;
use App\Rules\ApenasNumeros;
use App\Rules\CpfCnpjUnico;
use App\Rules\ValidarCpfCnpj;
use App\Rules\ValidarTelefone;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            DB::beginTransaction();
            $request->validate([
                'nome' => 'required|string',
                'cpf' => ['required|numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'tipo' => 'integer',
                'telefone' => ['required', new ValidarTelefone],
                'email' => 'required|email',
                'senha' => 'required|min:6'
            ]);

            $request->merge([
                'senha' => Hash::make($request->input('senha'))
            ]);

            Funcionario::create($request->all());

            DB::commit();

            return response()->json(["message" => "Funcionário cadastrado com sucesso!"], 201);
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
     * Atualiza um funcionário
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function atualizarFuncionario(Request $request, int $idFuncionario): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nome' => 'string', 
                'cpf' => ['numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'status' => 'integer',
                'tipo' => 'integer',
                'telefone' => new ValidarTelefone,
                'email' => 'email'
            ]);

            $funcionario = Funcionario::findOrFail($idFuncionario);

            $funcionario->update($request->all());

            DB::commit();

            return response()->json([
                "message" => "Funcionário atualizado com sucesso!",
                "data" => $funcionario
            ]);

        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            return response()->json(['errors' => 'Funcionário não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
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
    public function buscarFuncionarioPorId(int $idFuncionario): JsonResponse
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
}
