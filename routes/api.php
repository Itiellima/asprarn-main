<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Endpoints chamados pelo n8n (exigem o header x-api-key)
Route::middleware(App\Http\Middleware\VerificarTokenN8n::class)->group(function () {
    Route::get('/automacoes/executar', [App\Http\Controllers\AutomacaoController::class, 'executar']);
    Route::post('/automacoes/executar', [App\Http\Controllers\AutomacaoController::class, 'executar']);

    Route::get('/automacoes/test', [App\Http\Controllers\AutomacaoController::class, 'test']);
    Route::post('/automacoes/test', [App\Http\Controllers\AutomacaoController::class, 'test']);
});
