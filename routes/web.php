<?php

use App\Http\Controllers\ContaController;
use App\Http\Controllers\TransacaoController;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::middleware('api')->prefix('api')->group(function () {
    Route::get('/', static function () {
        return response()->json([
            'message' => 'API REST desafio-tecnico-objective'
        ], StatusCodeInterface::STATUS_OK);
    });

    Route::post('/conta', [ContaController::class, 'create']);
    Route::get('/conta', [ContaController::class, 'show']);
    Route::post('/transacao', [TransacaoController::class, 'processarTransacao']);
});
