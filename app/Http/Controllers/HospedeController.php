<?php

namespace App\Http\Controllers;

use App\Models\Hospede;
use App\Rules\ApenasNumeros;
use App\Rules\CpfCnpjUnico;
use App\Rules\ValidarCpfCnpj;
use App\Rules\ValidarTelefone;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class HospedeController extends Controller
{
    /**
     * Cadastra um hóspede
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function cadastrarHospede(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nome' => 'required|string',
                'cpf' => ['required',  new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico],
                'telefone' => ['required', new ValidarTelefone, new ApenasNumeros],
                'email' => 'required|email'
            ]);

            Hospede::create($request->all());
    
            return response()->json(["message" => "Hóspede cadastrado com sucesso!"], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Busca hóspedes pelo id do hóspede
     * 
     * @param int $idHospede
     * @return JsonResponse
     */
    public function buscarHospedePorId(int $idHospede): JsonResponse
    {
        try {
            $hospede = Hospede::find($idHospede);
    
            if (empty($hospede)) {
                return response()->json(['message' => 'Hóspede não encontrado.'], 404);
            }

            return response()->json($hospede);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }

    /**
     * Busca hóspedes por parte do nome
     * 
     * @param int $idHospede
     * @return JsonResponse
     */
    public function buscarHospedePorNome(Request $request): JsonResponse
    {
        try {
            $nomeHospede = $request->input('nomeHospede');

            $hospede = Hospede::where("nome", "like", "{$nomeHospede}%")->get();

            if (empty(count($hospede))) {
                return response()->json(['message' => 'Hóspede não encontrado.'], 404);
            }

            return response()->json($hospede);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }
}
