<?php

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrocarSenhaController;
use Illuminate\Support\Facades\Route;

// Qualquer usuário logado. Rotas com {id} de associado conferem no controller
// (autorizarAcessoAoAssociado) se o dado é do próprio associado ou se é admin/moderador.
Route::middleware(['auth'])->group(function () {

    //////////////////////////////// ********* TROCA OBRIGATÓRIA DE SENHA ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/trocar-senha', [TrocarSenhaController::class, 'show'])->name('senha.trocar');
    Route::post('/trocar-senha', [TrocarSenhaController::class, 'update'])->name('senha.trocar.salvar');

    //////////////////////////////// ********* DASHBOARD ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    Route::view('/profile', 'profile.show')->name('profile.view');
    Route::view('/associado/financeiro', 'dashboard.associado-financeiro')->name('associado.financeiro');

    //////////////////////////////// ********* DADOS DO ASSOCIADO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/asssociado/informacoes/{id}', [AssociadoController::class, 'associadoInfo'])->name('associado.informacoes');

    Route::post('/associado/{associadoId}/picture-profile/store', [AssociadoController::class, 'storePictureProfile'])->name('associado.picture-profile.store');
    Route::delete('/associado/{associadoId}/picture-profile/destroy', [AssociadoController::class, 'destroyPictureProfile'])->name('associado.picture-profile.destroy');

    Route::get('/carteira-associados/{id}', [AssociadoController::class, 'showCarteirinha'])->name('carteira-associados');
    Route::get('/carteira-associados1/{id}', [AssociadoController::class, 'showVerticalCarteirinha'])->name('carteira-associados-vertical');
});
