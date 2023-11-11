<?php

namespace App\Http\Controllers;

use App\Models\Hospede;
use App\Rules\ApenasNumeros;
use App\Rules\CpfCnpjUnico;
use App\Rules\ValidarCpfCnpj;
use App\Rules\ValidarTelefone;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HospedeController extends Controller
{
    public function cadastrarHospede(Request $request) 
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
}
