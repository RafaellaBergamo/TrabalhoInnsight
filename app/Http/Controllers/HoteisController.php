<?php

namespace App\Http\Controllers;

use App\Helpers\FuncionariosHelper;
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
                'endereco' => ['required', new ValidarEndereco]
            ]);

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
                'endereco' => new ValidarEndereco
            ]);

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
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna dados de um hotel pelo id
     * 
     * @param int|null $idHotel
     * @return JsonResponse
     * @throws ModelNotFoundException|Exception
     */
    public function buscarHotelPorId(int $idHotel = null): JsonResponse
    {
        try {
            if (empty($idHotel)) {
                throw new Exception("Id do hotel não enviado.");
            }

            $hotel = Hotel::findOrFail($idHotel);
    
            return response()->json($hotel);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Hotel não encontrado.'], 404);
        } catch (Exception $e) {
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
            $nomeHotel = $request->input('nomeHotel');

            if (empty($nomeHotel)) {
                return response()->json(Hotel::all());
            }

            $hotel = Hotel::where('razaoSocial', 'like', "{$nomeHotel}%")->get();

            if (empty(count($hotel))) {
                return response()->json(['message' => 'Nenhum hotel encontrado.'], 404);
            }
    
            return response()->json($hotel);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca todos os funcionários que fazem parte da governança do hotel
     * 
     * @return JsonResponse
     */
    public function buscarGovernancaDoHotel(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer'
            ]);

            $idHotel = $request->input('idHotel');
            $funcionarios = FuncionariosHelper::buscarGovernanca($idHotel);
    
            if (empty(count($funcionarios))) {
                return response()->json(['errors' => "Esse hotel não possui governança."], 500);
            }

            return response()->json($funcionarios);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

}
