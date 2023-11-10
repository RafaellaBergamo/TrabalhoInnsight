<?php

namespace App\Http\Controllers;

use App\Helpers\QuartosHelpers;
use App\Models\Quarto;
use App\Models\Hotel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuartosController extends Controller
{
    public function buscarQuartos(Request $request)
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer', 
                'idQuarto' => 'integer|nullable'
            ]);
    
            $idHotel = $request->input('idHotel');
            $idQuarto = $request->input('idQuarto');

            $quartos = Quarto::buscarQuartos($idHotel, $idQuarto);
        
            dd("teste");
            if (empty($quartos)) {
                return response()->json(['message' => 'Hotel informado não possui quarto cadastrado.'], 404);
            }
    
            return response()->json($quartos);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function cadastrarQuarto(Request $request) 
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer', 
                'qtdCamas' => 'required|integer'
            ]);
            
            $idHotel = $request->input('idHotel');

            if (empty(Hotel::find($idHotel))) {
                return response()->json(["message" => "Hotel {$idHotel} não encontrado."], 404);
            }

            $quarto = Quarto::create([
                'idHotel' => $idHotel,
                'qtdCamas' => $request->input('qtdCamas')
            ]);
    
            return response()->json(["message" => "Quarto cadastrado com sucesso!"]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function atualizarQuarto(Request $request) 
    {
        $request->validate([
            'idQuarto' => 'required|integer',
            'qtdCamas' => 'integer',
            'status' => 'integer'
        ]);

        $idQuarto = $request->input('idQuarto');

        $quarto = Quarto::find($idQuarto);

        if (!$quarto) {
            return response()->json(['message' => 'Quarto não encontrado.'], 404);
        }

        $dadosAtualizados = $request->input(['qtdCamas', 'status']);

        $quarto->fill($dadosAtualizados);
        $quarto->save();

        return response()->json([
            "message" => "Quarto atualizado com sucesso!",
            "data" => $quarto
        ]);
    }

    public function verificarStatusQuarto(Request $request) 
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
