<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContaController;
use Fig\Http\Message\StatusCodeInterface;
use App\Http\Controllers\TransacaoController;

Route::get('/', static function () {
    return view('welcome');
});

Route::middleware('api')->prefix('api')->group(function () {
    Route::get('/', static function () {
        return response()->json([
            'message' => 'API REST desafio-tecnico-objective'
        ], StatusCodeInterface::STATUS_OK);
    });

    Route::get('/conta', [ContaController::class, 'show']);
    Route::post('/conta', [ContaController::class, 'create']);
    Route::post('/transacao', [TransacaoController::class, 'processarTransacao']);
});
