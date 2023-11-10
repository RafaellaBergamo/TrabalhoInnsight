<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoteisController;
use App\Http\Controllers\QuartosController;

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
Route::put('/hoteis/{nomeHotel?}', [HoteisController::class, 'atualizarHotel']);

Route::post("/quartos", [QuartosController::class, 'cadastrarQuarto']);
Route::get("/quartos", [QuartosController::class, 'buscarQuartos']);
Route::get("/quartos/status", [QuartosController::class, 'verificarStatusQuarto']);
Route::put('/quartos', [QuartosController::class, 'atualizarQuarto']);
