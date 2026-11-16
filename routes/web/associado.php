<?php

use App\Http\Controllers\Associado\CarteirinhaController;
use App\Http\Controllers\Associado\FotoPerfilController;
use App\Http\Controllers\Associado\InformacoesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrocarSenhaController;
use Illuminate\Support\Facades\Route;

// Qualquer usuário logado. Rotas com {id} de associado conferem na AssociadoPolicy
// (app/Policies) se o dado é do próprio associado ou se é admin/moderador.
Route::middleware(['auth'])->group(function () {

    //////////////////////////////// ********* TROCA OBRIGATÓRIA DE SENHA ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/trocar-senha', [TrocarSenhaController::class, 'show'])->name('senha.trocar');
    Route::post('/trocar-senha', [TrocarSenhaController::class, 'update'])->name('senha.trocar.salvar');

    //////////////////////////////// ********* DASHBOARD ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    Route::view('/profile', 'profile.show')->name('profile.view');

    //////////////////////////////// ********* DADOS DO ASSOCIADO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/asssociado/informacoes/{id}', [InformacoesController::class, 'show'])->name('associado.informacoes');

    Route::post('/associado/{associadoId}/picture-profile/store', [FotoPerfilController::class, 'store'])->name('associado.picture-profile.store');
    Route::delete('/associado/{associadoId}/picture-profile/destroy', [FotoPerfilController::class, 'destroy'])->name('associado.picture-profile.destroy');

    Route::get('/carteira-associados/{id}', [CarteirinhaController::class, 'horizontal'])->name('carteira-associados');
    Route::get('/carteira-associados1/{id}', [CarteirinhaController::class, 'vertical'])->name('carteira-associados-vertical');
});
