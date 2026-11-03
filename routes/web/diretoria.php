<?php

use App\Http\Controllers\Diretoria\DiretoriaController;
use App\Http\Controllers\Diretoria\FuncaoController;
use App\Http\Controllers\Diretoria\MembroController;
use Illuminate\Support\Facades\Route;

// Diretoria, funções e membros: somente admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/diretoria', [DiretoriaController::class, 'index'])->name('diretoria.index');
    Route::get('/diretoria/create', [DiretoriaController::class, 'create'])->name('diretoria.create');
    Route::post('/diretoria/store', [DiretoriaController::class, 'store'])->name('diretoria.store');
    Route::delete('/diretorira/destroy/{id}', [DiretoriaController::class, 'destroy'])->name('diretoria.destroy');
    Route::get('/diretoria/edit/{id}', [DiretoriaController::class, 'edit'])->name('diretoria.edit');
    Route::put('/diretoria/update/{id}', [DiretoriaController::class, 'update'])->name('diretoria.update');

    Route::get('/diretoria/funcoes', [FuncaoController::class, 'index'])->name('diretoria.funcoes.index');
    Route::get('/diretoria/funcoes/create', [FuncaoController::class, 'create'])->name('diretoria.funcoes.create');
    Route::post('/diretoria/funcoes/store', [FuncaoController::class, 'store'])->name('diretoria.funcoes.store');
    Route::delete('/diretoria/funcoes/destroy/{id}', [FuncaoController::class, 'destroy'])->name('diretoria.funcoes.destroy');
    Route::get('/diretoria/funcoes/edit/{id}', [FuncaoController::class, 'edit'])->name('diretoria.funcoes.edit');
    Route::put('/diretoria/funcoes/update/{id}', [FuncaoController::class, 'update'])->name('diretoria.funcoes.update');

    Route::get('/diretoria/membros/index', [MembroController::class, 'index'])->name('diretoria.membros.index');
    Route::get('/diretoria/membros/create', [MembroController::class, 'create'])->name('diretoria.membros.create');
    Route::post('/diretoria/membros/store', [MembroController::class, 'store'])->name('diretoria.membros.store');
    Route::delete('/diretoria/membros/destroy/{id}', [MembroController::class, 'destroy'])->name('diretoria.membros.destroy');
    Route::get('/diretoria/membros/edit/{id}', [MembroController::class, 'edit'])->name('diretoria.membros.edit');
    Route::put('/diretoria/membros/update/{id}', [MembroController::class, 'update'])->name('diretoria.membros.update');
});
