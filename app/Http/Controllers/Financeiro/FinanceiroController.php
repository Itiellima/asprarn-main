<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinanceiroLancamento;
use App\Services\Financeiro\LancamentoService;
use Carbon\Carbon;

class FinanceiroController extends Controller
{
    public function index(LancamentoService $lancamentos)
    {
        // Saldo realizado: só o que já foi pago/recebido
        $saldoAtual = $lancamentos->saldo();

        // Receitas e despesas pagas no mês (pela data de pagamento)
        $totaisMes = $lancamentos->totaisDoPeriodo(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $receitasMes = $totaisMes['receitas'];
        $despesasMes = $totaisMes['despesas'];

        // Próximas contas a pagar e a receber (lançamentos pendentes)
        $contasPagar = $this->pendentes('despesa');
        $contasReceber = $this->pendentes('receita');

        // Últimos lançamentos
        $ultimosLancamentos = FinanceiroLancamento::with(['categoria', 'conta'])
            ->orderByDesc('data_lancamento')
            ->orderByDesc('id')
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

    private function pendentes(string $tipo)
    {
        return FinanceiroLancamento::pendentes()
            ->where('tipo', $tipo)
            ->orderByRaw('data_vencimento IS NULL')
            ->orderBy('data_vencimento')
            ->limit(10)
            ->get();
    }
}
