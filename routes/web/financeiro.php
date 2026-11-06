<?php

use App\Http\Controllers\Financeiro\CategoriaController;
use App\Http\Controllers\Financeiro\ContasBancariasController;
use App\Http\Controllers\Financeiro\ContasController;
use App\Http\Controllers\Financeiro\ExtratoController;
use App\Http\Controllers\Financeiro\FinanceiroController;
use App\Http\Controllers\Financeiro\LancamentosController;
use App\Http\Controllers\PagamentosController;
use App\Http\Controllers\PlanosController;
use Illuminate\Support\Facades\Route;

// Financeiro da associação: admin ou perfil financeiro
Route::middleware(['auth', 'role:admin|financeiro'])->group(function () {

    //////////////////////////////// ********* MENSALIDADES DOS ASSOCIADOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
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

    //////////////////////////////// ********* PLANOS ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    Route::get('/planos/index', [PlanosController::class, 'index'])->name('planos.index');
    Route::get('/planos/create', [PlanosController::class, 'create'])->name('planos.create');
    Route::post('/planos/store', [PlanosController::class, 'store'])->name('planos.store');
    Route::delete('/planos/destroy/{id}', [PlanosController::class, 'destroy'])->name('planos.destroy');
    Route::get('/planos/edit/{id}', [PlanosController::class, 'edit'])->name('planos.edit');
    Route::put('/planos/update/{id}', [PlanosController::class, 'update'])->name('planos.update');
    Route::get('/associado/financeiro/{associadoId}', [PlanosController::class, 'index'])->name('associado.financeiro.index');

    //////////////////////////////// ********* GESTÃO FINANCEIRA ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro.index');

    Route::get('/financeiro/categoria/index', [CategoriaController::class, 'categoria'])->name('financeiro.categoria.index');
    Route::get('/financeiro/categoria/create', [CategoriaController::class, 'createCategoria'])->name('financeiro.categoria.create');
    Route::post('/financeiro/categoria/criar', [CategoriaController::class, 'criarCategoria'])->name('financeiro.categoria.criar');
    Route::get('/financeiro/categoria/edit/{id}', [CategoriaController::class, 'editarCategoria'])->name('financeiro.categoria.editar');
    Route::put('/financeiro/categoria/editar/{id}', [CategoriaController::class, 'updateCategoria'])->name('financeiro.categoria.update');
    Route::delete('/financeiro/categoria/excluir/{id}', [CategoriaController::class, 'excluirCategoria'])->name('financeiro.categoria.excluir');

    Route::get('/financeiro/contas-bancarias/index', [ContasBancariasController::class, 'index'])->name('financeiro.contas_bancarias.index');
    Route::get('/financeiro/contas-bancarias/create', [ContasBancariasController::class, 'create'])->name('financeiro.contas_bancarias.create');
    Route::post('/financeiro/contas-bancarias/store', [ContasBancariasController::class, 'store'])->name('financeiro.contas_bancarias.store');
    Route::get('/financeiro/contas-bancarias/edit/{id}', [ContasBancariasController::class, 'edit'])->name('financeiro.contas_bancarias.edit');
    Route::put('/financeiro/contas-bancarias/update/{id}', [ContasBancariasController::class, 'update'])->name('financeiro.contas_bancarias.update');
    Route::delete('/financeiro/contas-bancarias/destroy/{id}', [ContasBancariasController::class, 'destroy'])->name('financeiro.contas_bancarias.destroy');

    // Contas a pagar (despesas) e a receber (receitas): mesmo controller, o tipo vem da rota
    foreach (['contas-a-pagar' => 'despesa', 'contas-a-receber' => 'receita'] as $prefixo => $tipo) {
        $acaoPagar = $tipo === 'despesa' ? 'pagar' : 'receber';
        $acaoCancelar = $tipo === 'despesa' ? 'cancelar-pagamento' : 'cancelar-recebimento';

        Route::prefix("financeiro/{$prefixo}")->group(function () use ($prefixo, $tipo, $acaoPagar, $acaoCancelar) {
            Route::get('/', [ContasController::class, 'index'])->defaults('tipo', $tipo)->name("{$prefixo}.index");
            Route::get('/create', [ContasController::class, 'create'])->defaults('tipo', $tipo)->name("{$prefixo}.create");
            Route::post('/', [ContasController::class, 'store'])->defaults('tipo', $tipo)->name("{$prefixo}.store");
            Route::get('/{id}/edit', [ContasController::class, 'edit'])->defaults('tipo', $tipo)->name("{$prefixo}.edit");
            Route::put('/{id}', [ContasController::class, 'update'])->defaults('tipo', $tipo)->name("{$prefixo}.update");
            Route::delete('/{id}', [ContasController::class, 'destroy'])->defaults('tipo', $tipo)->name("{$prefixo}.destroy");
            Route::put("/{id}/{$acaoPagar}", [ContasController::class, 'pagar'])->defaults('tipo', $tipo)->name("financeiro.{$prefixo}.{$acaoPagar}");
            Route::put("/{id}/{$acaoCancelar}", [ContasController::class, 'cancelar'])->defaults('tipo', $tipo)->name("financeiro.{$prefixo}.{$acaoCancelar}");
        });
    }

    Route::resource('financeiro/lancamentos', LancamentosController::class);
    Route::put('/financeiro/lancamentos/{id}/pagar', [LancamentosController::class, 'pagar'])->name('financeiro.lancamentos.pagar');
    Route::put('/financeiro/lancamentos/{id}/cancelar-recebimento', [LancamentosController::class, 'cancelarRecebimento'])->name('financeiro.lancamentos.cancelar-recebimento');

    Route::get('/financeiro/extrato', [ExtratoController::class, 'index'])->name('financeiro.extrato');
});
