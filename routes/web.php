<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\BeneficioController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DocumentoAssociadoController;
use App\Http\Controllers\HistoricoSituacoesController;
use App\Http\Controllers\RequerimentoController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PastaDocumentoController;

Route::get('/', [IndexController::class, 'index'])->name('index');


Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
});

Route::resource('beneficio', BeneficioController::class);

//View dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

//view requerimento para impressão
Route::get('/requerimento/{id}', [RequerimentoController::class, 'show'])->name('associado.pdf.requerimento');


Route::get('/associado/pasta_documento/{id}', [PastaDocumentoController::class, 'index'])->name('associado.pasta_documento.index');
Route::post('/associado/pasta_documento/store/{id}', [PastaDocumentoController::class, 'store'])->name('associado.pasta_documento.store');
Route::get('/associado/pasta_documento/show/{associado_id}/{pasta_id}', [PastaDocumentoController::class, 'show'])->name('associado.pasta_documento.show');










//////////////////////////////// ********* ASSOCIADO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//VIEW TODOS OS ASSOCIADOS
Route::get('/associado', [AssociadoController::class, 'index'])->name('associado.index');
//VIEW ASSOCIADO BY ID
Route::get('/associado/show/{id}', [AssociadoController::class, 'show'])->name('associado.show');
//VIEW NOVO ASSOCIADO
Route::get('/associado/create', [AssociadoController::class, 'create'])->name('associado.create');
//VIEW de edição
Route::get('/associado/edit/{id}', [AssociadoController::class, 'edit'])->name('associado.edit');
//ROTA STORE
Route::post('/associado/store', [AssociadoController::class, 'store'])->name('associado.store');
//ROTA UPDATE
Route::put('/associado/update/{id}', [AssociadoController::class, 'update'])->name('associado.update');
//ROTA DESTROY
Route::delete('/associado/delete/{id}', [AssociadoController::class, 'destroy'])->name('associado.destroy');


//////////////////////////////// ********* DOCUMENTOS ASSOCIADOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//VIEW DOCUMENTOS ASSOCIADOS
Route::get('/associado/documentos/{id}', [DocumentoAssociadoController::class, 'indexDocumento'])->name('associado.documentos.index');
//VIEW DOCUMENTO BY ID
Route::get('/associado/documentos/{id}/{documento}', [DocumentoAssociadoController::class, 'showDocumento'])->name('associado.documentos.show');
//ROTA STORE
Route::post('/associado/{id}/documentos', [DocumentoAssociadoController::class, 'storeDocumento'])->name('associado.documentos.store');
//ROTA UPDATE
Route::patch('/associado/{id}/documentos/{documento}', [DocumentoAssociadoController::class, 'updateDocumento'])->name('associado.documentos.update');
//ROTA DESTROY
Route::delete('/associado/{id}/documentos/{documento}', [DocumentoAssociadoController::class, 'destroyDocumento'])->name('associado.documentos.destroy');


//////////////////////////////// ********* SITUACAO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::post('/associado/situacao/{id}', [SituacaoController::class, 'storeSituacao'])->name('associado.situacao.store');


//////////////////////////////// ********* HISTORICO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::post('/associado/{id}/historico', [HistoricoSituacoesController::class, 'storeHistorico'])->name('associado.historico.store');
Route::delete('/associado/{id}/historico/{historico}', [HistoricoSituacoesController::class, 'destroyHistorico'])->name('associado.historico.destroy');


//////////////////////////////// ********* ADMIN ROTAS E VIEWS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware(['auth'])->group(function () {
    // View usuarios
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    // Rota para atualizar as permissoes de um usuario
    Route::post('/usuarios/{user}/role', [UsuariosController::class, 'updateRole'])->name('usuarios.updateRole');
});

Route::get('/profile', function () {
    return view('profile.show');
})->name('profile.view');
