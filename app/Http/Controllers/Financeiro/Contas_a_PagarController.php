<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroContaBancaria;
use App\Models\FinanceiroContasAPagar;
use Illuminate\Http\Request;


class Contas_a_PagarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = FinanceiroContasAPagar::with(['categoria', 'conta'])
            ->orderBy('data_lancamento', 'desc')
            ->get();

        return view('financeiro.contas_a_pagar.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = FinanceiroCategoria::orderBy('nome')->get();

        $contasBancarias = FinanceiroContaBancaria::orderBy('nome')->get();

        $conta = new FinanceiroContasAPagar();

        return view('financeiro.contas_a_pagar.create', compact(
            'categorias',
            'contasBancarias',
            'conta'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        FinanceiroContasAPagar::create($dados);

        return redirect()
            ->route('contas-a-pagar.index')
            ->with('success', 'Lançamento cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $conta = FinanceiroContasAPagar::findOrFail($id);

        $categorias = FinanceiroCategoria::orderBy('nome')->get();

        $contasBancarias = FinanceiroContaBancaria::orderBy('nome')->get();

        return view('financeiro.contas_a_pagar.create', compact(
            'conta',
            'categorias',
            'contasBancarias'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $conta = FinanceiroContasAPagar::findOrFail($id);

        $dados = $request->validate([
            'tipo'             => 'required|in:despesa,receita,transferencia',
            'valor'            => 'required|numeric|min:0',
            'data_lancamento'  => 'required|date',
            'data_vencimento'  => 'nullable|date',
            'data_pagamento'   => 'nullable|date',
            'repeticao'        => 'required|in:diaria,semanal,quinzenal,mensal,anual,unica',
            'categoria_id'     => 'nullable|exists:financeiro_categorias,id',
            'conta_id'         => 'nullable|exists:financeiro_contas_bancarias,id',
            'pago'             => 'boolean',
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
            ->route('contas-a-pagar.index')
            ->with('success', 'Lançamento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pagar(Request $request, string $id)
    {
        $conta = FinanceiroContasAPagar::findOrFail($id);

        $request->validate([
            'data_pagamento' => 'required|date',
        ]);

        $pago = $request->boolean('pago');

        $conta->update([
            'pago' => $pago,
            'data_pagamento' => $pago ? $request->data_pagamento : null,
        ]);

        return redirect()
            ->route('contas-a-pagar.index')
            ->with('success', $pago ? 'Lançamento marcado como pago com sucesso.' : 'Lançamento marcado como não pago com sucesso.');
    }
}
