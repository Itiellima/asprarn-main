<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroContaBancaria;
use App\Models\FinanceiroLancamento;
use App\Services\Financeiro\LancamentoService;
use DomainException;
use Illuminate\Http\Request;

class LancamentosController extends Controller
{
    public function __construct(private LancamentoService $lancamentos)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = FinanceiroLancamento::with(['categoria', 'conta'])
            ->orderByDesc('data_lancamento')
            ->orderByDesc('id')
            ->paginate(10);

        return view('financeiro.lancamentos.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('financeiro.lancamentos.create', $this->dadosDoFormulario(new FinanceiroLancamento()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->lancamentos->criar($this->validar($request) + ['situacao' => 'pendente']);

        return redirect()
            ->route('lancamentos.index')
            ->with('success', 'Lançamento cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('lancamentos.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('financeiro.lancamentos.create', $this->dadosDoFormulario(FinanceiroLancamento::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);

        return $this->executar(fn () => $this->lancamentos->atualizar($lancamento, $this->validar($request)),
            'Lançamento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);

        return $this->executar(fn () => $this->lancamentos->excluir($lancamento),
            'Lançamento excluído com sucesso.');
    }

    // Marca como pago (checkbox marcado) ou volta para pendente (desmarcado)
    public function pagar(Request $request, string $id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);

        if (!$request->boolean('situacao')) {
            return $this->executar(fn () => $this->lancamentos->reabrir($lancamento),
                'Lançamento voltou a ficar pendente.');
        }

        $request->validate(['data_pagamento' => 'required|date'], [
            'data_pagamento.required' => 'Informe a data de pagamento.',
        ]);

        return $this->executar(fn () => $this->lancamentos->pagar($lancamento, $request->input('data_pagamento')),
            'Lançamento marcado como pago.');
    }

    public function cancelarRecebimento(string $id)
    {
        $lancamento = FinanceiroLancamento::findOrFail($id);

        return $this->executar(fn () => $this->lancamentos->cancelar($lancamento),
            'Lançamento cancelado.');
    }

    private function validar(Request $request): array
    {
        $dados = $request->validate([
            'tipo' => 'required|in:despesa,receita,transferencia',
            'valor' => 'required|numeric|min:0.01',
            'data_lancamento' => 'required|date',
            'data_vencimento' => 'nullable|date',
            'repeticao' => 'nullable|in:diaria,semanal,quinzenal,mensal,anual,unica',
            'categoria_id' => 'nullable|exists:financeiro_categorias,id',
            'conta_id' => 'nullable|exists:financeiro_contas_bancarias,id',
            'descricao' => 'nullable|string|max:255',
            'observacao' => 'nullable|string',
        ]);

        $dados['repeticao'] = ($dados['repeticao'] ?? null) ?: 'unica';

        return $dados;
    }

    private function dadosDoFormulario(FinanceiroLancamento $conta): array
    {
        return [
            'conta' => $conta,
            'categorias' => FinanceiroCategoria::orderBy('nome')->get(),
            'contasBancarias' => FinanceiroContaBancaria::orderBy('nome')->get(),
        ];
    }

    private function executar(callable $acao, string $mensagem)
    {
        try {
            $acao();
        } catch (DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('lancamentos.index')->with('success', $mensagem);
    }
}
