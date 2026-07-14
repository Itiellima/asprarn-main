<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroContasAPagar;
use App\Models\FinanceiroContasAReceber;
use App\Models\FinanceiroLancamento;
use Carbon\Carbon;

class FinanceiroController extends Controller
{
    public function index()
    {
        $inicioMes = Carbon::now()->startOfMonth();
        $fimMes = Carbon::now()->endOfMonth();

        // Saldo atual
        $saldoAtual = FinanceiroLancamento::all()->reduce(function ($saldo, $lancamento) {

            return match ($lancamento->tipo) {
                'receita' => $saldo + $lancamento->valor,
                'despesa' => $saldo - $lancamento->valor,
                default => $saldo,
            };
        }, 0);

        // Receitas do mês
        $receitasMes = FinanceiroLancamento::where('tipo', 'receita')
            ->whereBetween('data_lancamento', [$inicioMes, $fimMes])
            ->sum('valor');

        // Despesas do mês
        $despesasMes = FinanceiroLancamento::where('tipo', 'despesa')
            ->whereBetween('data_lancamento', [$inicioMes, $fimMes])
            ->sum('valor');

        // Contas a pagar pendentes
        $contasPagar = FinanceiroContasAPagar::where('situacao', 'pendente')
            ->orderBy('data_vencimento')
            ->limit(10)
            ->get();

        // Contas a receber pendentes
        $contasReceber = FinanceiroContasAReceber::where('situacao', 'pendente')
            ->orderBy('data_vencimento')
            ->limit(10)
            ->get();

        // Últimos lançamentos
        $ultimosLancamentos = FinanceiroLancamento::with([
            'categoria',
            'conta'
        ])
            ->latest('data_lancamento')
            ->limit(10)
            ->get();

        return view(
            'financeiro.index',
            compact(
                'saldoAtual',
                'receitasMes',
                'despesasMes',
                'contasPagar',
                'contasReceber',
                'ultimosLancamentos'
            )
        );
    }
}
