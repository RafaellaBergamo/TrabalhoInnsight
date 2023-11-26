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


Route::post("/quartos", [QuartosController::class, 'cadastrarQuarto']);
Route::get("/quartos", [QuartosController::class, 'buscarQuartos']);
Route::get("/quartos/status", [QuartosController::class, 'buscarQuartosComOStatus']);
Route::put('/quartos', [QuartosController::class, 'atualizarQuarto']);

Route::post('/hospedes', [HospedeController::class, 'cadastrarHospede']);
Route::get('/hospedes', [HospedeController::class, 'buscarHospedePorNome']);
Route::get('/hospedes/{id}', [HospedeController::class, 'buscarHospedePorId']);
Route::put('/hospedes', [HospedeController::class, 'atualizarHospede']);

Route::post("/reservas", [ReservasController::class, 'cadastrarReserva']);
Route::get("/reservas/{id}", [ReservasController::class, 'buscarReserva']);
Route::put('/reservas', [ReservasController::class, 'atualizarReserva']);

Route::post("/funcionarios", [FuncionariosController::class, 'cadastrarFuncionario']);
Route::get("/funcionarios/{id}", [FuncionariosController::class, 'buscarFuncionario']);
Route::get("/funcionarios/hotel", [FuncionariosController::class, 'buscarFuncionarioDoHotel']);
Route::put('/funcionarios', [FuncionariosController::class, 'atualizarFuncionario']);

Route::post("/registros/checkin", [RegistrosHospedesController::class, 'registrarCheckin']);
Route::post("/registros/checkout", [RegistrosHospedesController::class, 'registrarCheckout']);

Route::post('/pagamentos', [PagamentosController::class, 'realizarPagamento']);
Route::get('/pagamentos', [PagamentosController::class, 'buscarDadosPagamento']);

Route::post('/produtos', [ProdutosController::class, 'cadastrarProduto']);
Route::get('/produtos', [ProdutosController::class, 'buscarProdutos']);
Route::put('/produtos', [ProdutosController::class, 'atualizarProduto']);

Route::get('/relatorios/hospedes', [RelatoriosController::class, 'gerarRelatorioHospedesDoHotel']);
Route::get('/relatorios/produtos', [RelatoriosController::class, 'gerarRelatorioProdutos']);