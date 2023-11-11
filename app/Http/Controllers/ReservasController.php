<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReservasController extends Controller
{
    public function cadastrarReserva(Request $request) 
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer', 
                'idHospede' => 'required|integer',
                'idQuarto' => 'required|integer',
                'dtEntrada' => 'required|date',
                'dtSaida' => 'required|date',
                'vlSaida' => 'required|float'
            ]);

            Reserva::create($request->all());
    
            return response()->json(["message" => "Reserva cadastrada com sucesso!"], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
