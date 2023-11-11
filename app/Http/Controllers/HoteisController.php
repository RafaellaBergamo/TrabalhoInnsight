<?php

namespace App\Http\Controllers;

use App\Helpers\DocumentoHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Models\Hotel;
use App\Rules\ApenasNumeros;
use App\Rules\ValidarCpfCnpj;
use App\Rules\CpfCnpjUnico;
use App\Rules\IsFilial;
use App\Rules\ValidarEndereco;
use App\Rules\ValidarTelefone;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HoteisController extends Controller
{
    /**
     * Cadastra um hotel
     * 
     * @throws ValidationException
     */
    public function cadastrarHotel(Request $request) 
    {
        try {
            $request->validate([
                'cnpj' => ['required', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico, new IsFilial],
                'razaoSocial' => 'required|string',
                'qtdQuartos' => 'required|integer',
                'telefone' => ['required', new ValidarTelefone, new ApenasNumeros],
                'endereco' => ['required', new ValidarEndereco]
            ]);

            Hotel::create([
                'cnpj' => $request->input('cnpj'),
                'razaoSocial' => $request->input('razaoSocial'),
                'qtdQuartos' => $request->input('qtdQuartos'),
                'telefone' => $request->input('telefone'),
                'endereco' => $request->input('endereco')
            ]);
    
            return response()->json(["message" => "Hotel cadastrado com sucesso!"], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function atualizarHotel(Request $request) 
    {
        try {
            $request->validate([
                'idHotel' => 'required', 
                'cnpj' => ['numeric', new ApenasNumeros, new ValidarCpfCnpj, new CpfCnpjUnico, new IsFilial],
                'qtdQuartos' => 'integer',
                'telefone' => [new ValidarTelefone, new ApenasNumeros],
                'endereco' => new ValidarEndereco
            ]);

            $idHotel = $request->input('idHotel');

            $hotel = Hotel::findOrFail($idHotel);

            $hotel->update($request->all());

            return response()->json([
                "message" => "Hotel atualizado com sucesso!", 
                "data" => $hotel
            ]);

        } catch (ModelNotFoundException $ex) {
            return response()->json(['errors' => 'Hotel não encontrado.'], 404);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna dados de um hotel pelo id
     * 
     * @param int|null $idHotel
     * 
     */
    public function buscarHotelPorId($idHotel)
    {
        try {
            $hotel = Hotel::find($idHotel);
    
            if (empty($hotel)) {
                return response()->json(['message' => 'Hotel não encontrado.'], 404);
            }
    
            return response()->json($hotel);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function buscarHoteis(Request $request) 
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

}
