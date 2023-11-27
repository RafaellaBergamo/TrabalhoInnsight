<?php

namespace App\Http\Controllers;

use App\Helpers\FuncionariosHelper;
use App\Helpers\HoteisHelper;
use App\Models\Funcionario;
use Illuminate\Http\Request;

use App\Models\Hotel;
use App\Rules\ApenasNumeros;
use App\Rules\ValidarCpfCnpj;
use App\Rules\CpfCnpjUnico;
use App\Rules\IsFilial;
use App\Rules\ValidarEndereco;
use App\Rules\ValidarTelefone;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HoteisController extends Controller
{
    /**
     * Cadastra um hotel
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function cadastrarHotel(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'cnpj' => ['required', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'razaoSocial' => 'required|string',
                'qtdQuartos' => 'required|integer',
                'telefone' => ['required', new ValidarTelefone, new ApenasNumeros],
                'endereco' => ['required', new ValidarEndereco],
                'emailFuncionario' => 'required|email',
                'senhaFuncionario' => 'required'
            ]);

            $email = $request->input('emailFuncionario');
            $senha = $request->input('senhaFuncionario');

            if (!FuncionariosHelper::funcionarioComAcesso($email, $senha, [Funcionario::MASTER])) {
                throw new Exception("Funcionário sem acesso.");
            }

            Hotel::create($request->all());
            
            DB::commit();
            return response()->json(["message" => "Hotel cadastrado com sucesso!"], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Atualiza um hotel
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function atualizarHotel(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'idHotel' => 'required',
                'razaoSocial' => 'string',
                'cnpj' => ['numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico, new IsFilial],
                'qtdQuartos' => 'integer',
                'telefone' => [new ValidarTelefone, new ApenasNumeros],
                'endereco' => new ValidarEndereco,
                'emailFuncionario' => 'required|email',
                'senhaFuncionario' => 'required'
            ]);

            $email = $request->input('emailFuncionario');
            $senha = $request->input('senhaFuncionario');

            if (!FuncionariosHelper::funcionarioComAcesso($email, $senha, [Funcionario::MASTER])) {
                throw new Exception("Funcionário sem acesso.");
            }

            $idHotel = $request->input('idHotel');

            $hotel = Hotel::findOrFail($idHotel);

            $hotel->update($request->all());

            DB::commit();
            return response()->json([
                "message" => "Hotel atualizado com sucesso!", 
                "data" => $hotel
            ]);

        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Hotel não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca hotéis, pode ser por parte do nome ou todos.
     * 
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function buscarHoteis(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'idHotel' => 'integer',
                'razaoSocial' => 'string'
            ]);

            $idHotel = $request->input('idHotel');
            $razaoSocial = $request->input('razaoSocial');

            $hoteis = HoteisHelper::buscarHoteis($idHotel, (string) $razaoSocial);

            if (empty($hoteis)) {
                return response()->json(['message' => 'Nenhum hotel encontrado.'], 404);
            }
    
            dd("teste");
            return response()->json($hoteis);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

}
