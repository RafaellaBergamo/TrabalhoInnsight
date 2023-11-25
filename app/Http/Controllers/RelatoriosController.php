<?php

namespace App\Http\Controllers;

use App\Helpers\HospedesHelper;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RelatoriosController extends Controller
{
    /**
     * Cadastra um quarto
     * 
     * @param Request $request
     */
    public function gerarRelatorioHospedesDoHotel(Request $request)
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer'
            ]);

            $idHotel = $request->input('idHotel');
            $hospedes = HospedesHelper::buscarHospedesDoHotel($idHotel);

            $relatorio = FacadePdf::loadView('relatorios.relatorioHospedes', ["hospedes" => $hospedes]);

            $nomeArquivo = "relatorioHospedes.pdf";

            return response($relatorio->output(), 200)
                ->header('Content-Type', 'application/pdf');
        } catch (ModelNotFoundException $ex) {
            return response()->json(['error' => 'Hotel não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}