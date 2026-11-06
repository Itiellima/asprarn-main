<?php

use App\Http\Controllers\AcaoJudicialController;
use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\AutomacaoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BeneficioController;
use App\Http\Controllers\ComoNosEncontrouController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\DocumentoAssociadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\HistoricoSituacoesController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\OpmController;
use App\Http\Controllers\PastaDocumentoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrestadorDeServicosController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\RequerimentoController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\SorteioController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

// Painel administrativo: admin ou moderador
Route::middleware(['auth', 'role:admin|moderador'])->group(function () {

    //////////////////////////////// ********* ASSOCIADO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/associado', [AssociadoController::class, 'index'])->name('associado.index');
    Route::get('/associado/show/{id}', [AssociadoController::class, 'show'])->name('associado.show');
    Route::get('/associado/edit/{id}', [AssociadoController::class, 'edit'])->name('associado.edit');
    Route::put('/associado/update/{id}', [AssociadoController::class, 'update'])->name('associado.update');
    Route::delete('/associado/delete/{id}', [AssociadoController::class, 'destroy'])->name('associado.destroy');
    Route::post('/associado/resetpassword/{id}', [AssociadoController::class, 'resetPassword'])->name('associado.reset.password');
    //////////////////////////////// ********* SITUACAO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::post('/associado/situacao/{id}', [SituacaoController::class, 'storeSituacao'])->name('associado.situacao.store');
    Route::post('/situacao/store', [SituacaoController::class, 'store'])->name('situacao.store');
    Route::post('/situacao/update/{associadoId}', [SituacaoController::class, 'update'])->name('situacao.update');
    Route::delete('/situacao/destroy/{id}', [SituacaoController::class, 'destroy'])->name('situacao.destroy');
    Route::put('/situacao/edit/{id}', [SituacaoController::class, 'edit'])->name('situacao.edit');

    //////////////////////////////// ********* HISTORICO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::post('/associado/{id}/historico', [HistoricoSituacoesController::class, 'storeHistorico'])->name('associado.historico.store');
    Route::delete('/associado/{id}/historico/{historico}', [HistoricoSituacoesController::class, 'destroyHistorico'])->name('associado.historico.destroy');
    Route::put('/associado/{id}/historico/{historico}', [HistoricoSituacoesController::class, 'update'])->name('associado.historico.update');

    //////////////////////////////// ********* PASTAS E DOCUMENTOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/associado/pasta/index/{associadoId}', [PastaDocumentoController::class, 'index'])->name('associado.pasta.index');
    Route::post('/associado/pasta/store/{associadoId}', [PastaDocumentoController::class, 'store'])->name('associado.pasta.store');
    Route::get('/associado/pasta/show/{associadoId}/{pastaId}', [PastaDocumentoController::class, 'show'])->name('associado.pasta.show');
    Route::delete('/associado/pasta/destroy/{associadoId}/{pastaId}', [PastaDocumentoController::class, 'destroy'])->name('associado.pasta.destroy');

    Route::post('/associado/pasta/documentos/store/{pastaId}', [DocumentoAssociadoController::class, 'store'])->name('associado.pasta.documentos.store');
    Route::get('/associado/pasta/documentos/show/{pastaId}/{fileId}', [DocumentoAssociadoController::class, 'show'])->name('associado.pasta.documentos.show');
    Route::delete('/associado/pasta/documentos/destroy/{pastaId}/{fileId}', [DocumentoAssociadoController::class, 'destroy'])->name('associado.pasta.documentos.destroy');
    Route::patch('/associado/pasta/documentos/update/{pastaId}/{fileId}', [DocumentoAssociadoController::class, 'update'])->name('associado.documentos.update');

    //////////////////////////////// ********* DOCUMENTOS PARA IMPRESSÃO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/pdf.requerimento/{id}', [RequerimentoController::class, 'show'])->name('associado.pdf.requerimento');
    Route::get('/pdf.sesc/{id}', [RequerimentoController::class, 'sesc'])->name('associado.pdf.sesc');
    Route::get('/pdf.unp/{id}', [RequerimentoController::class, 'unp'])->name('associado.pdf.unp');
    Route::get('/pdf.declaracao/{id}', [RequerimentoController::class, 'declaracao'])->name('associado.pdf.declaracao');
    Route::get('/pdf.desfiliacao/{id}', [RequerimentoController::class, 'desfiliacao'])->name('associado.pdf.desfiliacao');
    Route::get('/pdf.termo-de-adesao-acp/{id}', [RequerimentoController::class, 'termoDeAdesaoAcp'])->name('associado.pdf.termo-de-adesao-acp');
    Route::get('/pdf.beneficiarios-procuracao/{id}', [RequerimentoController::class, 'beneficiariosProcuracao'])->name('associado.pdf.beneficiarios-procuracao');
    Route::get('/pdf.declaracao-associado-promocao/{id}', [RequerimentoController::class, 'declaracaoAssociadoPromocao'])->name('associado.pdf.declaracao-associado-promocao');

    //////////////////////////////// ********* SITE: POSTS, BENEFÍCIOS E BANNERS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('beneficio/create', [BeneficioController::class, 'create'])->name('beneficio.create');
    Route::post('beneficio/store', [BeneficioController::class, 'store'])->name('beneficio.store');
    Route::get('beneficio/edit/{beneficio}', [BeneficioController::class, 'edit'])->name('beneficio.edit');
    Route::put('beneficio/update/{beneficio}', [BeneficioController::class, 'update'])->name('beneficio.update');
    Route::delete('beneficio/destroy/{beneficio}', [BeneficioController::class, 'destroy'])->name('beneficio.destroy');
    Route::post('beneficio/ordenar', [BeneficioController::class, 'ordenar'])->name('beneficio.ordenar');
    Route::get('beneficio/order', [BeneficioController::class, 'order'])->name('beneficio.order');

    Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
    Route::post('/banner/store', [BannerController::class, 'store'])->name('banner.store');
    Route::delete('/banner/destroy/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');

    //////////////////////////////// ********* CADASTROS DA ASSOCIAÇÃO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios.index');
    Route::get('/funcionarios/create', [FuncionarioController::class, 'create'])->name('funcionarios.create');
    Route::post('/funcionarios/store', [FuncionarioController::class, 'store'])->name('funcionarios.store');
    Route::delete('/funcionarios/destroy/{id}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');
    Route::get('/funcionarios/show/{id}', [FuncionarioController::class, 'show'])->name('funcionarios.show');
    Route::put('/funcionarios/update/{id}', [FuncionarioController::class, 'update'])->name('funcionarios.update');

    Route::get('/prestador-de-servicos-autonomos', [PrestadorDeServicosController::class, 'index'])->name('prestador-de-servicos-autonomos.index');
    Route::get('/prestador-de-servicos-autonomos/create', [PrestadorDeServicosController::class, 'create'])->name('prestador-de-servicos-autonomos.create');
    Route::post('/prestador-de-servicos-autonomos/store', [PrestadorDeServicosController::class, 'store'])->name('prestador-de-servicos-autonomos.store');
    Route::get('/prestador-de-servicos-autonomos/edit/{id}', [PrestadorDeServicosController::class, 'edit'])->name('prestador-de-servicos-autonomos.edit');
    Route::put('/prestador-de-servicos-autonomos/update/{id}', [PrestadorDeServicosController::class, 'update'])->name('prestador-de-servicos-autonomos.update');
    Route::delete('/prestador-de-servicos-autonomos/destroy/{id}', [PrestadorDeServicosController::class, 'destroy'])->name('prestador-de-servicos-autonomos.destroy');

    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('/empresas/store', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('/empresas/show/{id}', [EmpresaController::class, 'show'])->name('empresas.show');
    Route::put('/empresas/update/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/empresas/destroy/{id}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');

    //////////////////////////////// ********* CONFIGURAÇÕES ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/configuracoes', [ConfiguracoesController::class, 'index'])->name('configuracoes.index');

    Route::post('/configuracoes/opms/store', [OpmController::class, 'store'])->name('opms.store');
    Route::delete('/configuracoes/opms/destroy/{id}', [OpmController::class, 'destroy'])->name('opms.destroy');

    Route::post('/acao-judicial/store', [AcaoJudicialController::class, 'store'])->name('acao-judicial.store');
    Route::delete('/acao-judicial/destroy/{id}', [AcaoJudicialController::class, 'destroy'])->name('acao-judicial.destroy');
    Route::put('/acao-judicial/update/{id}', [AcaoJudicialController::class, 'update'])->name('acao-judicial.update');
    Route::post('/acao-judicial/update-acoes/{id}', [AcaoJudicialController::class, 'updateAcoes'])->name('acao-judicial.update-acoes');

    Route::get('/automacoes/index', [AutomacaoController::class, 'index'])->name('automacoes.index');
    Route::post('/automacoes/create', [AutomacaoController::class, 'create'])->name('automacoes.create');
    Route::delete('/automacoes/destroy/{id}', [AutomacaoController::class, 'destroy'])->name('automacoes.destroy');

    //////////////////////////////// ********* NOTIFICAÇÕES E RELATÓRIOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/notificacoes/index', [NotificacaoController::class, 'index'])->name('notificacoes.index');
    Route::post('/notificacoes/marcar-como-lida/{id}', [NotificacaoController::class, 'marcarComoLida'])->name('notificacoes.marcarComoLida');

    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::get('/relatorios/gerar/todos', [RelatorioController::class, 'gerarRelatorio'])->name('relatorios.gerar.todos');
    Route::get('/como-nos-encontrou', [ComoNosEncontrouController::class, 'index'])->name('como-nos-encontrou.index');

    //////////////////////////////// ********* SORTEIOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::resource('sorteios', SorteioController::class);
    Route::post('/sorteios/{id}/participante', [SorteioController::class, 'adicionarParticipante'])->name('sorteios.participante.store');
    Route::post('/sorteios/{id}/sortear', [SorteioController::class, 'sortear'])->name('sorteios.sortear');
    Route::post('/sorteios/{id}/encerrar', [SorteioController::class, 'encerrar'])->name('sorteios.encerrar');

    //////////////////////////////// ********* USUÁRIOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    // Moderador também reseta (o controller impede resetar a senha de um admin)
    Route::post('/usuarios/{id}/reset-password', [UsuariosController::class, 'resetPassword'])->name('usuarios.resetPassword');
});

// Somente admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios/{user}/role', [UsuariosController::class, 'updateRole'])->name('usuarios.updateRole');
    Route::delete('/usuarios/{user}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
});
