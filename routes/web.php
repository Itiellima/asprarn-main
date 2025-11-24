<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
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
use App\Http\Controllers\PlanosController;
use App\Http\Controllers\BannerController;

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
});

//////////////////////////////// ********* BENEFICIO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::resource('beneficio', BeneficioController::class);

//////////////////////////////// ********* DASHBOARD ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//////////////////////////////// ********* PDFS IMPRESSAO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/requerimento/{id}', [RequerimentoController::class, 'show'])->name('associado.pdf.requerimento');
Route::get('/associado.pdf.sesc/{id}', [RequerimentoController::class, 'sesc'])->name('associado.pdf.sesc');

//////////////////////////////// ********* CRUD PASTA ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/associado/pasta/index/{associadoId}', [PastaDocumentoController::class, 'index'])->name('associado.pasta.index');
Route::post('/associado/pasta/store/{associadoId}', [PastaDocumentoController::class, 'store'])->name('associado.pasta.store');
Route::get('/associado/pasta/show/{associadoId}/{pastaId}', [PastaDocumentoController::class, 'show'])->name('associado.pasta.show');
Route::delete('/associado/pasta/destroy/{associadoId}/{pastaId}', [PastaDocumentoController::class, 'destroy'])->name('associado.pasta.destroy');

//////////////////////////////// ********* DOCUMENTOS ASSOCIADOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//STORE
Route::post('/associado/pasta/documentos/store/{pastaId}', [DocumentoAssociadoController::class, 'store'])->name('associado.pasta.documentos.store');
//SHOW BY ID
Route::get('/associado/pasta/documentos/show/{pastaId}/{fileId}', [DocumentoAssociadoController::class, 'show'])->name('associado.pasta.documentos.show');
//DESTROY
Route::delete('/associado/pasta/documentos/destroy/{pastaId}/{fileId}', [DocumentoAssociadoController::class, 'destroy'])->name('associado.pasta.documentos.destroy');

//UPDATE
Route::patch('/associado/{id}/documentos/{documento}', [DocumentoAssociadoController::class, 'updateDocumento'])->name('associado.documentos.update');

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

//////////////////////////////// ********* ASSOCIADO FINANCEIRO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/associado/financeiro/{associadoId}', [PlanosController::class, 'index'])->name('associado.financeiro.index');

//////////////////////////////// ********* SITUACAO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::post('/associado/situacao/{id}', [SituacaoController::class, 'storeSituacao'])->name('associado.situacao.store');
Route::post('/situacao/store', [SituacaoController::class, 'store'])->name('situacao.store');
Route::post('/situacao/update/{associadoId}' , [SituacaoController::class, 'update'])->name('situacao.update');
Route::delete('/situacao/destroy/{id}', [SituacaoController::class, 'destroy'])->name('situacao.destroy');

//////////////////////////////// ********* HISTORICO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::post('/associado/{id}/historico', [HistoricoSituacoesController::class, 'storeHistorico'])->name('associado.historico.store');
Route::delete('/associado/{id}/historico/{historico}', [HistoricoSituacoesController::class, 'destroyHistorico'])->name('associado.historico.destroy');

//////////////////////////////// ********* ADMIN ROTAS E VIEWS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware(['auth'])->group(function () {
    // View usuarios
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    // Rota para atualizar as permissoes de um usuario
    Route::post('/usuarios/{user}/role', [UsuariosController::class, 'updateRole'])->name('usuarios.updateRole');
    Route::delete('/usuarios/{user}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
});

//////////////////////////////// ********* LOGIN/REGISTER ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/register', [AssociadoController::class, 'create'])->name('register.view');

//////////////////////////////// ********* PLANOS ASSOCIADO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/planos/index', [PlanosController::class, 'index'])->name('planos.index');
Route::get('/planos/create', [PlanosController::class, 'create'])->name('planos.create');
Route::post('/planos/store', [PlanosController::class, 'store'])->name('planos.store');
Route::delete('/planos/destroy/{id}', [PlanosController::class, 'destroy'])->name('planos.destroy');
Route::get('/planos/edit/{id}', [PlanosController::class, 'edit'])->name('planos.edit');
Route::put('/planos/update/{id}', [PlanosController::class, 'update'])->name('planos.update');

///////////////////////////////// ********* BANNER ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
Route::post('/banner/store', [BannerController::class, 'store'])->name('banner.store');
Route::delete('/banner/destroy/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');

///////////////////////////////// ********* ROTAS ESTATICAS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/contatos', function(){
    return view('contato.index');
})->name('contato.index');

Route::get('/Quem_Somos', function(){
    return view('quem-somos.index');
})->name('quem.somos');

Route::get('/associado/financeiro', function(){
    return view('dashboard.associado-financeiro');
})->name('associado.financeiro');

Route::get('/profile', function () {
    return view('profile.show');
})->name('profile.view');
