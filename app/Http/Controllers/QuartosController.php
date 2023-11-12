<?php

namespace App\Http\Controllers;

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
                'qtdCamas' => 'required|integer',
                'capacidade' => 'required|integer|min:1'
            ]);
            
            $idHotel = $request->input('idHotel');

            Hotel::findOrFail($idHotel);

            Quarto::create($request->all());
    
            return response()->json(["message" => "Quarto cadastrado com sucesso!"]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Hotel não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
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
                'idHotel' => 'required|integer',
                'idQuarto' => 'required|integer',
                'qtdCamas' => 'integer',
                'capacidade' => 'integer|min:1',
                'status' => 'integer'
            ]);

            $idQuarto = $request->input('idQuarto');
            $idHotel = $request->input('idHotel');
    
            $quarto = Quarto::buscarQuartos($idHotel, $idQuarto)->first();

            if (empty($quarto)) {
                throw new Exception("Hotel informado não possui quarto cadastrado.", 404);
            }

            $quarto->save($request->all());
    
            return response()->json([
                "message" => "Quarto atualizado com sucesso!",
                "data" => $quarto
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(["errors" => "Quarto não encontrado."], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
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

    public function buscarQuartosComOStatus(string $statusQuarto) 
    {
        $estadosPermitidos = [
            'disponiveis' => Quarto::DISPONIVEL,
            'ocupados' => Quarto::OCUPADO,
            'sujos' => Quarto::SUJO,
        ];
    
        // Verifica se o status fornecido é válido
        if (!isset($estadosPermitidos[$statusQuarto])) {
            return response()->json(['error' => 'Status de quarto inválido.'], 400);
        }
    
        // Realiza a consulta no banco de dados usando o status mapeado
        $quartos = Quarto::where('status', '=', $estadosPermitidos[$statusQuarto])->get();
    
        return response()->json($quartos);
    }
}
