<?php

use App\Http\Controllers\FuncionariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoteisController;
use App\Http\Controllers\QuartosController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\HospedeController;
use App\Http\Controllers\PagamentosController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\RegistrosHospedesController;
use App\Http\Controllers\RelatoriosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/hoteis')->group(function () {
    Route::post('/', [HoteisController::class, 'cadastrarHotel']);
    Route::get('/', [HoteisController::class, 'buscarHoteis']);
    Route::put('/', [HoteisController::class, 'atualizarHotel']);
});

Route::prefix('/quartos')->group(function () {
    Route::post("/", [QuartosController::class, 'cadastrarQuarto']);
    Route::get("/", [QuartosController::class, 'buscarQuartos']);
    Route::get("/status", [QuartosController::class, 'buscarQuartosComOStatus']);
    Route::put('/', [QuartosController::class, 'atualizarQuarto']);
});

Route::prefix('/hospedes')->group(function () {
    Route::post('/', [HospedeController::class, 'cadastrarHospede']);
    Route::get('/', [HospedeController::class, 'buscarHospedePorNome']);
    Route::get('/{id}', [HospedeController::class, 'buscarHospedePorId']);
    Route::put('/', [HospedeController::class, 'atualizarHospede']);
});

Route::prefix('/reservas')->group(function () {
    Route::post("/", [ReservasController::class, 'cadastrarReserva']);
    Route::get("/", [ReservasController::class, 'buscarReservaPorHospede']);
    Route::get("/{id}", [ReservasController::class, 'buscarReserva']);
    Route::put('/', [ReservasController::class, 'atualizarReserva']);
});

Route::prefix('/funcionarios')->group(function () {
    Route::post("/", [FuncionariosController::class, 'cadastrarFuncionario']);
    Route::get("/{id}", [FuncionariosController::class, 'buscarFuncionarioPorId']);
    Route::get("/hotel", [FuncionariosController::class, 'buscarFuncionarioDoHotel']);
    Route::put('/', [FuncionariosController::class, 'atualizarFuncionario']);
});

Route::prefix('/produtos')->group(function () {
    Route::post('/', [ProdutosController::class, 'cadastrarProduto']);
    Route::get('/', [ProdutosController::class, 'buscarProdutos']);
    Route::put('/', [ProdutosController::class, 'atualizarProduto']);
});

Route::prefix('/registros')->group(function () {
    Route::post("/checkin", [RegistrosHospedesController::class, 'registrarCheckin']);
    Route::post("/checkout", [RegistrosHospedesController::class, 'registrarCheckout']);
});

Route::prefix('/pagamentos')->group(function () {
    Route::post('/', [PagamentosController::class, 'realizarPagamento']);
    Route::get('/', [PagamentosController::class, 'buscarDadosPagamento']);
});

Route::prefix('/relatorios')->group(function () {
    Route::get('/hospedes', [RelatoriosController::class, 'gerarRelatorioHospedesDoHotel']);
    Route::get('/produtos', [RelatoriosController::class, 'gerarRelatorioProdutos']);
});
