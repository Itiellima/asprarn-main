<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinanceiroContaBancaria;
use App\Models\FinanceiroContasAPagar;
use App\Models\FinanceiroLancamento;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExtratoController extends Controller
{
    public function index(Request $request)
    {
        $contas = FinanceiroContaBancaria::orderBy('nome', 'asc')->get();

        $movimentacoes = FinanceiroLancamento::with([
            'categoria',
            'conta'
        ])
            ->when($request->conta_id, function ($query) use ($request) {
                $query->where('conta_id', $request->conta_id);
            })
            ->when($request->inicio, function ($query) use ($request) {
                $query->whereDate('data_lancamento', '>=', $request->inicio);
            })
            ->when($request->fim, function ($query) use ($request) {
                $query->whereDate('data_lancamento', '<=', $request->fim);
            })
            ->orderBy('data_lancamento', 'desc')
            ->get();

        $saldo = 0;

        foreach ($movimentacoes as $movimento) {

            if ($movimento->tipo == 'receita') {
                $saldo += $movimento->valor;
            }

            if ($movimento->tipo == 'despesa') {
                $saldo -= $movimento->valor;
            }

            $movimento->saldo = $saldo;
        }

        return view(
            'financeiro.extrato.index',
            compact('contas', 'movimentacoes')
        );
    }
}
