<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Hotel;
use App\Rules\ApenasNumeros;
use App\Rules\CpfCnpjUnico;
use App\Rules\ValidarCpfCnpj;
use App\Rules\ValidarTelefone;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;

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
                'cpf' => ['numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'tipo' => 'integer',
                'telefone' => ['required', new ValidarTelefone],
                'email' => 'required|email',
                'senha' => 'required|min:6',
                'idHotel' => 'required'
            ]);

            $request->merge([
                'senha' => Hash::make($request->input('senha'))
            ]);

            Hotel::findOrFail($request->input('idHotel'));
            Funcionario::create($request->all());

            DB::commit();

            return response()->json(["message" => "Funcionário cadastrado com sucesso!"], 201);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            return response()->json(['errors' => 'Hotel não encontrado.'], 404);
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
    public function atualizarFuncionario(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'idFuncionario' => 'required',
                'idHotel' => 'integer',
                'nome' => 'string', 
                'cpf' => ['numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'status' => 'integer',
                'tipo' => 'integer',
                'telefone' => new ValidarTelefone,
                'email' => 'email'
            ]);

            $idFuncionario = $request->input('idFuncionario');

            $funcionario = Funcionario::findOrFail($idFuncionario);

            $idHotel = $request->input('idHotel');

            if (
                !empty($idHotel)
                && empty(Hotel::find($request->input('idHotel')))
            ) {
                throw new Exception("Hotel não encontrado.");
            }

            $funcionario->update($request->all());

            DB::commit();

            return response()->json([
                "message" => "Funcionário atualizado com sucesso!",
                "data" => $funcionario
            ]);

        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            return response()->json(['errors' => 'Funcionário não encontrado.'], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function atualizarSenha(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'senha' => 'required|min:6',
                'novaSenha' => 'required|min:6|confirmed',
            ]);
    
            $funcionario = Auth::user();
    
            // Verificar a senha atual
            if (!Hash::check($request->input('password'), $funcionario->senha)) {
                return response()->json(['errors' => 'Senha atual incorreta.'], 500);
            }
    
            $funcionario = Funcionario::findOrFail(FacadesSession::get('idFuncionario'));
    
            $request->merge([
                'senha' => Hash::make($request->input('novaSenha'))
            ]);
    
            $funcionario->update($request->all());

            DB::commit();
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
