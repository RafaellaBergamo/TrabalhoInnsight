<?php

namespace App\Http\Controllers;

use App\Helpers\FuncionariosHelper;
use App\Helpers\HospedesHelper;
use App\Helpers\ProdutosHelper;
use App\Models\Funcionario;
use App\Models\Hotel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RelatoriosController extends Controller
{
    /**
     * Gera um relatório de todos os hóspedes atuais do Hotel
     * 
     * @param Request $request
     */
    public function gerarRelatorioHospedesDoHotel(Request $request)
    {
        try {
            $request->validate([
                'idHotel' => 'required|integer',
                'emailFuncionario' => 'required|email',
                'senhaFuncionario' => 'required'
            ]);

            $email = $request->input('emailFuncionario');
            $senha = $request->input('senhaFuncionario');

            if (!FuncionariosHelper::funcionarioComAcesso($email, $senha, [Funcionario::MASTER])) {
                throw new Exception("Funcionário sem acesso.");
            }

            $idHotel = $request->input('idHotel');
            $hospedes = HospedesHelper::buscarHospedesDoHotel($idHotel);

            $relatorio = FacadePdf::loadView('relatorios.relatorioHospedes', ["hospedes" => $hospedes]);

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

    /**
     * Gera um relatório de produtos
     * 
     * @param Request $request
     */
    public function gerarRelatorioProdutos(Request $request)
    {
        try {
            $request->validate([
                'emailFuncionario' => 'required|email',
                'senhaFuncionario' => 'required',
                'idHotel' => 'integer',
                'idProduto' => 'integer',
                'descricao' => 'string'
            ]);

            $email = $request->input('emailFuncionario');
            $senha = $request->input('senhaFuncionario');

            if (!FuncionariosHelper::funcionarioComAcesso($email, $senha, [Funcionario::MASTER])) {
                throw new Exception("Funcionário sem acesso.");
            }

            $idHotel = $request->input('idHotel');
            $idProduto = $request->input('idProduto');
            $descricao = $request->input('descricao');

            $produtos = ProdutosHelper::buscarProdutos($idProduto, $idHotel, (string) $descricao);

            $relatorio = FacadePdf::loadView('relatorios.relatorioProdutos', ["produtos" => $produtos]);

            return response($relatorio->output(), 200)
                ->header('Content-Type', 'application/pdf');
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }