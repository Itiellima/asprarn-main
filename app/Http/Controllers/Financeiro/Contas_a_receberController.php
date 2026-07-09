<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroContaBancaria;
use App\Models\FinanceiroContasAReceber;
use Illuminate\Http\Request;

class Contas_a_receberController extends Controller
{
    public function index()
    {
        $contas = FinanceiroContasAReceber::with(['categoria', 'conta'])
            ->orderBy('data_lancamento', 'desc')
            ->get();

        return view('financeiro.contas_a_receber.index', compact('contas'));
    }

    public function create()
    {
        $categorias = FinanceiroCategoria::orderBy('nome')->get();

        $contasBancarias = FinanceiroContaBancaria::orderBy('nome')->get();

        $conta = new FinanceiroContasAReceber();

        return view('financeiro.contas_a_receber.create', compact(
            'categorias',
            'contasBancarias',
            'conta'
        ));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'tipo'             => 'required|in:despesa,receita,transferencia',
            'valor'            => 'required|numeric|min:0',
            'data_lancamento'  => 'required|date',
            'data_vencimento'  => 'nullable|date',
            'repeticao'        => 'required|in:diaria,semanal,quinzenal,mensal,anual,unica',
            'categoria_id'     => 'nullable|exists:financeiro_categorias,id',
            'conta_id'         => 'nullable|exists:financeiro_contas_bancarias,id',
            'descricao'        => 'nullable|string|max:255',
            'observacao'       => 'nullable|string',
        ]);

        // Salva o nome da categoria para manter histórico
        if (!empty($dados['categoria_id'])) {

            $categoria = FinanceiroCategoria::select('id', 'nome')->find($dados['categoria_id']);

            $dados['categoria'] = $categoria->nome;
        }

        // Salva uma descrição da conta para manter histórico
        if (!empty($dados['conta_id'])) {

            $conta = FinanceiroContaBancaria::select('id', 'nome')->find($dados['conta_id']);

            $dados['conta'] = $conta->nome;
        }

        FinanceiroContasAReceber::create($dados);

        return redirect()
            ->route('contas-a-receber.index')
            ->with('success', 'Lançamento cadastrado com sucesso.');
    }

    public function edit(string $id)
    {
        $conta = FinanceiroContasAReceber::findOrFail($id);

        $categorias = FinanceiroCategoria::orderBy('nome')->get();

        $contasBancarias = FinanceiroContaBancaria::orderBy('nome')->get();

        return view('financeiro.contas_a_receber.create', compact(
            'conta',
            'categorias',
            'contasBancarias'
        ));
    }

    public function update(Request $request, string $id)
    {
        $conta = FinanceiroContasAReceber::findOrFail($id);

        $dados = $request->validate([
            'tipo'             => 'required|in:despesa,receita,transferencia',
            'valor'            => 'required|numeric|min:0',
            'data_lancamento'  => 'required|date',
            'data_vencimento'  => 'nullable|date',
            'data_pagamento'   => 'nullable|date',
            'repeticao'        => 'required|in:diaria,semanal,quinzenal,mensal,anual,unica',
            'categoria_id'     => 'nullable|exists:financeiro_categorias,id',
            'conta_id'         => 'nullable|exists:financeiro_contas_bancarias,id',
            'descricao'        => 'nullable|string|max:255',
            'observacao'       => 'nullable|string',
        ]);

        $categoria = FinanceiroCategoria::select('id', 'nome')->find($dados['categoria_id']);

        $dados['categoria_nome'] = $categoria?->nome;

        try {
            $conta->update($dados);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar o lançamento: ' . $e->getMessage());
        }

        return redirect()
            ->route('contas-a-receber.index')
            ->with('success', 'Lançamento atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        $conta = FinanceiroContasAReceber::findOrFail($id);

        try {
            $conta->delete();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir o lançamento: ' . $e->getMessage());
        }

        return redirect()
            ->route('contas-a-receber.index')
            ->with('success', 'Lançamento excluído com sucesso.');
    }

    public function pagar(Request $request, string $id)
    {
        $conta = FinanceiroContasAReceber::findOrFail($id);

        $request->validate([
            'data_pagamento' => 'required|date',
        ]);

        $situacao = $request->boolean('situacao') ? 'pago' : 'pendente';

        $conta->update([
            'situacao' => $situacao,
            'data_pagamento' => $situacao === 'pago' ? $request->data_pagamento : null,
        ]);

        return redirect()
            ->route('contas-a-receber.index')
            ->with('success', $situacao === 'pago' ? 'Lançamento marcado como pago com sucesso.' : 'Lançamento marcado como não pago com sucesso.');
    }

    public function cancelar(Request $request, string $id)
    {
        $conta = FinanceiroContasAReceber::findOrFail($id);

        $request->validate([
            'data_cancelamento' => 'required|date',
        ]);

        $situacao = 'cancelado';

        $conta->update([
            'situacao' => $situacao,
            'data_cancelamento' => $situacao === 'cancelado' ? $request->data_cancelamento : null,
        ]);

        return redirect()
            ->route('contas-a-receber.index')
            ->with('success', $situacao === 'cancelado' ? 'Lançamento marcado como cancelado com sucesso.' : 'Lançamento marcado como não cancelado com sucesso.');
    }
}
