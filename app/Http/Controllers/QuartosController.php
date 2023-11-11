<?php

namespace App\Http\Controllers;

use App\Helpers\QuartosHelpers;
use App\Models\Quarto;
use App\Models\Hotel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            $request->validate([
                'idHotel' => 'required|integer', 
                'qtdCamas' => 'required|integer'
            ]);
            
            $idHotel = $request->input('idHotel');

            Hotel::findOrFail($idHotel);

            Quarto::create([
                'idHotel' => $idHotel,
                'qtdCamas' => $request->input('qtdCamas')
            ]);
    
            return response()->json(["message" => "Quarto cadastrado com sucesso!"]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Hotel não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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
            $request->validate([
                'idQuarto' => 'required|integer',
                'qtdCamas' => 'integer',
                'status' => 'integer'
            ]);
    
            $idQuarto = $request->input('idQuarto');
    
            $quarto = Quarto::findOrFail($idQuarto);
    
            $quarto->update($quarto);
    
            return response()->json([
                "message" => "Quarto atualizado com sucesso!",
                "data" => $quarto
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(["errors" => "Quarto não encontrado."], 404);
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
                'idQuarto' => 'integer|nullable'
            ]);
    
            $idHotel = $request->input('idHotel');
            $idQuarto = $request->input('idQuarto');

            $quartos = Quarto::buscarQuartos($idHotel, $idQuarto);

            if (empty($quartos)) {
                return response()->json(['message' => 'Hotel informado não possui quarto cadastrado.'], 404);
            }
    
            return response()->json($quartos);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna o status do quarto informado por parâmetro
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function verificarStatusQuarto(Request $request): JsonResponse 
    {
        $request->validate([
            'idQuarto' => 'required', 
        ]);

        $idQuarto = $request->input('idQuarto');

        $status = "ocupado";
        if (QuartosHelpers::quartoDisponivel($idQuarto)) {
            $status = "disponível";
        }

        return response()->json(['message' => "O quarto {$idQuarto} está {$status}"]);
    }
}
