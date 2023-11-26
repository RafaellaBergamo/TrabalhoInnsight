<?php

namespace App\Http\Controllers;

use App\Helpers\QuartosHelper;
use App\Models\Quarto;
use App\Models\Hotel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QuartosController extends Controller
{
    /**
     * Cadastra um quarto
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function cadastrarQuarto(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'idHotel' => 'required|integer', 
                'qtdCamas' => 'required|integer|min:1',
                'capacidade' => 'required|integer|min:1'
            ]);
            
            $idHotel = $request->input('idHotel');

            Hotel::findOrFail($idHotel);

            Quarto::create($request->all());
    
            DB::commit();
            return response()->json(["message" => "Quarto cadastrado com sucesso!"]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['error' => 'Hotel não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Atualiza um quarto
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function atualizarQuarto(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'idHotel' => 'required|integer',
                'idQuarto' => 'required|integer',
                'qtdCamas' => 'integer',
                'capacidade' => 'integer|min:1',
                'status' => 'integer'
            ]);

            $idQuarto = $request->input('idQuarto');
            $idHotel = $request->input('idHotel');
    
            $quartoAtualizado = Quarto::atualizarDadosQuarto($idQuarto, $idHotel, $request->all());
    
            DB::commit();
            return response()->json([
                "message" => "Quarto atualizado com sucesso!",
                "data" => $quartoAtualizado
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(["error" => "Quarto não encontrado."], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        } finally {
            DB::closeConnection();
        }
    }

    /**
     * Busca quartos de um hotel
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function buscarQuartos(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer', 
                'idQuarto' => 'integer',
                'status' => 'string'
            ]);
    
            $idHotel = $request->input('idHotel');
            $idQuarto = $request->input('idQuarto');

            $quartos = Quarto::buscarQuartos($idHotel, $idQuarto);

            if (empty($quartos)) {
                return response()->json(['message' => 'Hotel informado não possui quarto cadastrado.'], 404);
            }
    
            return response()->json($quartos);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna os quartos com o status enviado por parametro
     * 
     * @param string $statusQuarto
     * @return JsonResponse
     */
    public function buscarQuartosComOStatus(Request $request): JsonResponse 
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer', 
                'status' => 'string|required'
            ]);

            $statusQuarto = $request->input('status');
            $idHotel = $request->input('idHotel');

            $quartos = QuartosHelper::buscarQuartosDoHotelPorStatus($idHotel, $statusQuarto);

            return response()->json($quartos);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
