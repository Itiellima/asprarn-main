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

        $contas = FinanceiroContaBancaria::orderBy('nome')->get();

        return view('financeiro.contas_a_pagar.create', compact(
            'categorias',
            'contas'
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

        $contas = FinanceiroContaBancaria::orderBy('nome')->get();

        return view('financeiro.contas_a_pagar.create', compact(
            'conta',
            'categorias',
            'contas'
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

        // Categoria
        if (!empty($dados['categoria_id'])) {

            $categoria = FinanceiroCategoria::find($dados['categoria_id']);

            $dados['categoria_nome'] = $categoria->nome;
        } else {

            $dados['categoria_nome'] = null;
        }

        // Conta bancária
        if (!empty($dados['conta_id'])) {

            $contaBancaria = FinanceiroContaBancaria::find($dados['conta_id']);

            $dados['conta_nome'] = $contaBancaria->nome;
        } else {

            $dados['conta_nome'] = null;
        }

        $conta->update($dados);

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
}
