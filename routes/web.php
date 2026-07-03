<?php

use App\Http\Controllers\AcaoJudicialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\AutomacaoController;
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
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\searchPostController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\OpmController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\PrestadorDeServicosController;
use App\Http\Controllers\PagamentosController;
use App\Http\Controllers\ComoNosEncontrouController;
use App\Http\Controllers\Financeiro\FinanceiroController;
use App\Http\Controllers\Financeiro\CategoriaController;
use App\Http\Controllers\Financeiro\ContasBancariasController;
use App\Http\Controllers\Financeiro\Contas_a_PagarController;
use App\Http\Controllers\Diretoria\DiretoriaController;
use App\Http\Controllers\Diretoria\FuncaoController;
use App\Http\Controllers\Diretoria\MembroController;
use App\Http\Controllers\PerguntasFrequentesController;
use App\Http\Controllers\SorteioController;

use App\Models\PerguntasFrequentes;

//////////////////////////////// ********* INDEX ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Route::get('/', [IndexController::class, 'index'])->name('index');

//////////////////////////////// ********* CRUD POSTS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware(['auth'])->group(function () {
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

//////////////////////////////// ********* BENEFICIO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Route::get('beneficio/create', [BeneficioController::class, 'create'])->name('beneficio.create');
Route::post('beneficio/store', [BeneficioController::class, 'store'])->name('beneficio.store');
Route::get('beneficio/edit/{beneficio}', [BeneficioController::class, 'edit'])->name('beneficio.edit');
Route::put('beneficio/update/{beneficio}', [BeneficioController::class, 'update'])->name('beneficio.update');
Route::delete('beneficio/destroy/{beneficio}', [BeneficioController::class, 'destroy'])->name('beneficio.destroy');
Route::get('beneficio', [BeneficioController::class, 'index'])->name('beneficio.index');

Route::post('beneficio/ordenar', [BeneficioController::class, 'ordenar'])->name('beneficio.ordenar');
Route::get('beneficio/order', [BeneficioController::class, 'order'])->name('beneficio.order');

//////////////////////////////// ********* DASHBOARD ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//////////////////////////////// ********* PDFS IMPRESSAO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/pdf.requerimento/{id}', [RequerimentoController::class, 'show'])->name('associado.pdf.requerimento');
Route::get('/pdf.sesc/{id}', [RequerimentoController::class, 'sesc'])->name('associado.pdf.sesc');
Route::get('/pdf.unp/{id}', [RequerimentoController::class, 'unp'])->name('associado.pdf.unp');
Route::get('/pdf.declaracao/{id}', [RequerimentoController::class, 'declaracao'])->name('associado.pdf.declaracao');
Route::get('/pdf.desfiliacao/{id}', [RequerimentoController::class, 'desfiliacao'])->name('associado.pdf.desfiliacao');


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
//ROTA INFORMACOES ASSSOCIADO
Route::get('/asssociado/informacoes/{id}', [AssociadoController::class, 'associadoInfo'])->name('associado.informacoes');

Route::post('/associado/resetpassword/{id}', [AssociadoController::class, 'resetPassword'])->name('associado.reset.password');



//////////////////////////////// ********* PICTURE PROFILES ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::post('/associado/{associadoId}/picture-profile/store', [AssociadoController::class, 'storePictureProfile'])->name('associado.picture-profile.store');
Route::delete('/associado/{associadoId}/picture-profile/destroy', [AssociadoController::class, 'destroyPictureProfile'])->name('associado.picture-profile.destroy');

//////////////////////////////// ********* ASSOCIADO FINANCEIRO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/associado/financeiro/{associadoId}', [PlanosController::class, 'index'])->name('associado.financeiro.index');

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

//////////////////////////////// ********* ADMIN ROTAS E VIEWS USER ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware(['auth'])->group(function () {
    // View usuarios
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    // Rota para atualizar as permissoes de um usuario
    Route::post('/usuarios/{user}/role', [UsuariosController::class, 'updateRole'])->name('usuarios.updateRole');
    Route::delete('/usuarios/{user}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
    Route::post('/usuarios/{id}/reset-password', [UsuariosController::class, 'resetPassword'])->name('usuarios.resetPassword');
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

///////////////////////////////// ********* INSTAGRAM API ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/api/instagram/media', [InstagramController::class, 'getMedia']);

///////////////////////////////// ********* CONFIGURAÇÕES ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/configuracoes', [App\Http\Controllers\ConfiguracoesController::class, 'index'])->name('configuracoes.index');

///////////////////////////////// ********* ROTAS ESTATICAS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/contatos', function () {
    return view('contato.index');
})->name('contato.index');

Route::get('/Quem_Somos', function () {
    return view('quem-somos.index');
})->name('quem.somos');

Route::get('/associado/financeiro', function () {
    return view('dashboard.associado-financeiro');
})->name('associado.financeiro');

Route::get('/profile', function () {
    return view('profile.show');
})->name('profile.view');

Route::get('/api/cidades/{uf}', function ($uf) {
    return Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios")
        ->json();
});

Route::get('/api/cidades/{uf}', [AssociadoController::class, 'cidades']);

Route::get('/search', [searchPostController::class, 'index'])->name('search');

///////////////////////////////// ********* WHATSAPP ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// NAO UTILIZADO, VERIFICAR E DELETAR
Route::post('/enviar-mensagens', [WhatsappController::class, 'enviarMensagens'])->name('whatsapp.enviarMensagens');

Route::get('/automacoes/index', [AutomacaoController::class, 'index'])->name('automacoes.index');
Route::post('/automacoes/create', [AutomacaoController::class, 'create'])->name('automacoes.create');
Route::delete('/automacoes/destroy/{id}', [AutomacaoController::class, 'destroy'])->name('automacoes.destroy');


Route::get('/notificacoes/index', [NotificacaoController::class, 'index'])->name('notificacoes.index');
Route::post('/notificacoes/marcar-como-lida/{id}', [NotificacaoController::class, 'marcarComoLida'])->name('notificacoes.marcarComoLida');


///////////////////////////////// ********* RELATORIOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
Route::get('/relatorios/gerar/todos', [RelatorioController::class, 'gerarRelatorio'])->name('relatorios.gerar.todos');


///////////////////////////////// ********* CONFIGURACOES OPMS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::post('/configuracoes/opms/store', [OpmController::class, 'store'])->name('opms.store');
Route::delete('/configuracoes/opms/destroy/{id}', [OpmController::class, 'destroy'])->name('opms.destroy');


///////////////////////////////// ********* FUNCIONARIOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios.index');
Route::get('/funcionarios/create', [FuncionarioController::class, 'create'])->name('funcionarios.create');
Route::post('/funcionarios/store', [FuncionarioController::class, 'store'])->name('funcionarios.store');
Route::delete('/funcionarios/destroy/{id}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');
Route::get('/funcionarios/show/{id}', [FuncionarioController::class, 'show'])->name('funcionarios.show');
Route::put('/funcionarios/update/{id}', [FuncionarioController::class, 'update'])->name('funcionarios.update');

////////////////////////////////// ********* PRESTADOR DE SERVICOS AUTONOMOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/prestador-de-servicos-autonomos', [PrestadorDeServicosController::class, 'index'])->name('prestador-de-servicos-autonomos.index');
Route::get('/prestador-de-servicos-autonomos/create', [PrestadorDeServicosController::class, 'create'])->name('prestador-de-servicos-autonomos.create');
Route::post('/prestador-de-servicos-autonomos/store', [PrestadorDeServicosController::class, 'store'])->name('prestador-de-servicos-autonomos.store');
Route::get('/prestador-de-servicos-autonomos/edit/{id}', [PrestadorDeServicosController::class, 'edit'])->name('prestador-de-servicos-autonomos.edit');
Route::put('/prestador-de-servicos-autonomos/update/{id}', [PrestadorDeServicosController::class, 'update'])->name('prestador-de-servicos-autonomos.update');
Route::delete('/prestador-de-servicos-autonomos/destroy/{id}', [PrestadorDeServicosController::class, 'destroy'])->name('prestador-de-servicos-autonomos.destroy');

////////////////////////////////// ********* EMPRESAS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
Route::post('/empresas/store', [EmpresaController::class, 'store'])->name('empresas.store');
Route::get('/empresas/show/{id}', [EmpresaController::class, 'show'])->name('empresas.show');
Route::put('/empresas/update/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
Route::delete('/empresas/destroy/{id}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');


////////////////////////////////// ********* CARTEIRA ASSOCIADOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/carteira-associados/{id}', [AssociadoController::class, 'showCarteirinha'])->name('carteira-associados');
Route::get('/carteira-associados1/{id}', [AssociadoController::class, 'showVerticalCarteirinha'])->name('carteira-associados-vertical');
Route::get('/carteira-associado-verificacao/{id}', [AssociadoController::class, 'validarCarteirinha'])->name('validar-carteirinha');


////////////////////////////////// ********* PAGAMENTOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/importar-pagamentos', [PagamentosController::class, 'index'])->name('importar-pagamentos.index');
Route::post('/importar-pagamentos/read-archive', [PagamentosController::class, 'readArchive'])->name('importar-pagamentos.readArchive');
Route::post('/importar-pagamentos/processar', [PagamentosController::class, 'processarPagamentos'])->name('importar-pagamentos.processar');

Route::get('/pagamentos/index', [PagamentosController::class, 'pagamentosIndex'])->name('pagamentos.index');
Route::get('/pagamentos/show/{associadoId}', [PagamentosController::class, 'show'])->name('pagamentos.show');
Route::get('/pagamentos/edit/{pagamentoId}', [PagamentosController::class, 'edit'])->name('pagamentos.edit');
Route::put('/pagamentos/update/{pagamentoId}', [PagamentosController::class, 'update'])->name('pagamentos.update');
Route::get('/pagamentos/create/{associadoId}', [PagamentosController::class, 'create'])->name('pagamentos.create');
Route::post('/pagamentos/store/{associadoId}', [PagamentosController::class, 'store'])->name('pagamentos.store');
Route::delete('/pagamentos/destroy/{pagamentoId}', [PagamentosController::class, 'destroy'])->name('pagamentos.destroy');


////////////////////////////////// ********* COMO NOS ENCONTROU ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/como-nos-encontrou', [ComoNosEncontrouController::class, 'index'])->name('como-nos-encontrou.index');


////////////////////////////////// ********* ACAO JUDICIAL ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/acao-judicial', [AcaoJudicialController::class, 'index'])->name('acao-judicial.index');
Route::post('/acao-judicial/store', [AcaoJudicialController::class, 'store'])->name('acao-judicial.store');
Route::delete('/acao-judicial/destroy/{id}', [AcaoJudicialController::class, 'destroy'])->name('acao-judicial.destroy');
Route::put('/acao-judicial/update/{id}', [AcaoJudicialController::class, 'update'])->name('acao-judicial.update');
Route::post('/acao-judicial/update-acoes/{id}', [AcaoJudicialController::class, 'updateAcoes'])->name('acao-judicial.update-acoes');


////////////////////////////////// ********* FINANCEIRO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::middleware(['auth', 'role:admin|financeiro'])->group(function () {


    Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro.index');

    Route::get('/financeiro/categoria', [CategoriaController::class, 'categoria'])->name('financeiro.categoria');
    Route::get('/financeiro/categoria/create', [CategoriaController::class, 'createCategoria'])->name('financeiro.categoria.create');
    Route::post('/financeiro/categoria/criar', [CategoriaController::class, 'criarCategoria'])->name('financeiro.categoria.criar');
    Route::get('/financeiro/categoria/edit/{id}', [CategoriaController::class, 'editarCategoria'])->name('financeiro.categoria.editar');
    Route::put('/financeiro/categoria/editar/{id}', [CategoriaController::class, 'updateCategoria'])->name('financeiro.categoria.update');
    Route::delete('/financeiro/categoria/excluir/{id}', [CategoriaController::class, 'excluirCategoria'])->name('financeiro.categoria.excluir');


    Route::get('/financeiro/contas-bancarias', [ContasBancariasController::class, 'index'])->name('financeiro.contas_bancarias');
    Route::get('/financeiro/contas-bancarias/create', [ContasBancariasController::class, 'create'])->name('financeiro.contas_bancarias.create');
    Route::post('/financeiro/contas-bancarias/store', [ContasBancariasController::class, 'store'])->name('financeiro.contas_bancarias.store');
    Route::get('/financeiro/contas-bancarias/edit/{id}', [ContasBancariasController::class, 'edit'])->name('financeiro.contas_bancarias.edit');
    Route::put('/financeiro/contas-bancarias/update/{id}', [ContasBancariasController::class, 'update'])->name('financeiro.contas_bancarias.update');

    Route::resource('financeiro/contas-a-pagar', Contas_a_PagarController::class);
    
});

// DIRETORIA / FUNCOES / MEMBROS
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

Route::middleware(['auth', 'role:admin|moderador'])->group(function () {
    
    Route::resource('sorteios', SorteioController::class);

    Route::post('/sorteios/{id}/participante', [SorteioController::class, 'adicionarParticipante'])->name('sorteios.participante.store');
    
    Route::post('/sorteios/{id}/sortear', [SorteioController::class, 'sortear'])->name('sorteios.sortear');

    Route::post('/sorteios/{id}/encerrar', [SorteioController::class, 'encerrar'])->name('sorteios.encerrar');
});



Route::get('/perguntasfrequentes/index', [PerguntasFrequentesController::class, 'index'])->name('perguntasfrequentes.index');



// Exemplo rota protegida por middleware de autenticação e autorização
// Route::middleware(['auth', 'role:admin|moderador'])->group(function () {
//     Route::get('/configuracoes', [App\Http\Controllers\ConfiguracoesController::class, 'index'])->name('configuracoes.index');
//     Route::post('/acao-judicial/store', [AcaoJudicialController::class, 'store'])->name('acao-judicial.store');
// });
