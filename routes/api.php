<?php

use App\Http\Controllers\FuncionariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoteisController;
use App\Http\Controllers\QuartosController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\HospedeController;

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

Route::post('/hoteis', [HoteisController::class, 'cadastrarHotel']);
Route::get('/hoteis', [HoteisController::class, 'buscarHoteis']);
Route::get('/hoteis/{id}', [HoteisController::class, 'buscarHotelPorId']);
Route::get("/hoteis/governanca", [HoteisController::class, 'buscarGovernancaDoHotel']);
Route::put('/hoteis', [HoteisController::class, 'atualizarHotel']);

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