<?php

use App\Http\Controllers\ContaController;
use App\Http\Controllers\TransacaoController;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::get('/api', static function () {
    return response()->json([
        'message' => 'API REST desafio-tecnico-objective'
    ], StatusCodeInterface::STATUS_OK);
});


Route::middleware('api')->prefix('api')->group(function () {
    Route::post('/conta', [ContaController::class, 'create']);
    Route::get('/conta', [ContaController::class, 'show']);
    Route::post('/transacao', [TransacaoController::class, 'processarTransacao']);
});
