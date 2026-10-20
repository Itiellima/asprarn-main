<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinanceiroContaBancaria;
use App\Models\FinanceiroLancamento;
use App\Services\Financeiro\LancamentoService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExtratoController extends Controller
{
    /**
     * Extrato do que foi efetivamente pago/recebido, em ordem cronológica,
     * com saldo acumulado a partir do saldo anterior ao período.
     * Sem período informado, mostra o mês atual.
     */
    public function index(Request $request, LancamentoService $lancamentos)
    {
        $request->validate([
            'conta_id' => 'nullable|integer',
            'inicio' => 'nullable|date',
            'fim' => 'nullable|date|after_or_equal:inicio',
        ]);

        $contas = FinanceiroContaBancaria::orderBy('nome', 'asc')->get();

        $contaId = $request->integer('conta_id') ?: null;
        $inicio = $request->filled('inicio') ? Carbon::parse($request->input('inicio')) : Carbon::now()->startOfMonth();
        $fim = $request->filled('fim') ? Carbon::parse($request->input('fim')) : Carbon::now()->endOfMonth();

        // Saldo de tudo que foi pago antes do início do período
        $saldoAnterior = $lancamentos->saldo($contaId, $inicio->copy()->subDay());

        $movimentacoes = FinanceiroLancamento::with(['categoria', 'conta'])
            ->pagos()
            ->when($contaId, fn ($query) => $query->where('conta_id', $contaId))
            ->whereDate('data_pagamento', '>=', $inicio->toDateString())
            ->whereDate('data_pagamento', '<=', $fim->toDateString())
            ->orderBy('data_pagamento')
            ->orderBy('id')
            ->get();

        $saldo = $saldoAnterior;

        foreach ($movimentacoes as $movimento) {
            $saldo += match ($movimento->tipo) {
                'receita' => (float) $movimento->valor,
                'despesa' => -(float) $movimento->valor,
                default => 0,
            };

            $movimento->saldo = $saldo;
        }

        $saldoFinal = $saldo;

        return view(
            'financeiro.extrato.index',
            compact('contas', 'movimentacoes', 'saldoAnterior', 'saldoFinal', 'inicio', 'fim')
        );
    }
}
