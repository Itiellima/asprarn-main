<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/automacoes/executar', [App\Http\Controllers\AutomacaoController::class, 'executar']);
Route::post('/automacoes/executar', [App\Http\Controllers\AutomacaoController::class, 'executar']);
