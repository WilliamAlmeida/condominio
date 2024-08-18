<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CepController;
use App\Http\Controllers\Api\CidadesController;
use App\Http\Controllers\Api\CnpjController;
use App\Http\Controllers\Api\EstadosController;
use App\Http\Controllers\Api\MoradoresController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cep/{cep}', [CepController::class, 'show'])->name('api.cep.show');
Route::get('cnpj/{cnpj}', [CnpjController::class, 'show'])->name('api.cnpj.show');

Route::get('moradores', [MoradoresController::class, 'index'])->name('api.moradores');
Route::get('estados', [EstadosController::class, 'index'])->name('api.estados');
Route::get('cidades', [CidadesController::class, 'index'])->name('api.cidades');