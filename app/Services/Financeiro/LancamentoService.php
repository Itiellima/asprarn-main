<?php

namespace App\Services\Financeiro;

use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroLancamento;
use App\Models\Pagamento;
use Carbon\Carbon;
use DomainException;
use Illuminate\Support\Facades\DB;

/**
 * Regras do financeiro num lugar só: cadastro, pagamento, cancelamento,
 * saldo e a receita gerada pelos pagamentos de mensalidade.
 */
class LancamentoService
{
    public function criar(array $dados): FinanceiroLancamento
    {
        return FinanceiroLancamento::create($this->prepararDados($dados) + [
            'origem' => FinanceiroLancamento::ORIGEM_MANUAL,
        ]);
    }

    public function atualizar(FinanceiroLancamento $lancamento, array $dados): FinanceiroLancamento
    {
        $this->impedirAlteracaoDePagamento($lancamento);

        // Situação e data de pagamento só mudam por pagar()/reabrir()/cancelar()
        unset($dados['situacao'], $dados['data_pagamento']);

        $lancamento->update($this->prepararDados($dados));

        return $lancamento;
    }

    public function excluir(FinanceiroLancamento $lancamento): void
    {
        $this->impedirAlteracaoDePagamento($lancamento);

        $lancamento->delete();
    }

    public function pagar(FinanceiroLancamento $lancamento, $dataPagamento): FinanceiroLancamento
    {
        $this->impedirAlteracaoDePagamento($lancamento);

        if ($lancamento->situacao === 'cancelado') {
            throw new DomainException('Um lançamento cancelado não pode ser pago.');
        }

        $lancamento->update([
            'situacao' => 'pago',
            'data_pagamento' => Carbon::parse($dataPagamento)->toDateString(),
        ]);

        return $lancamento;
    }

    // Desfaz o pagamento: volta a ser pendente e sai do saldo
    public function reabrir(FinanceiroLancamento $lancamento): FinanceiroLancamento
    {
        $this->impedirAlteracaoDePagamento($lancamento);

        $lancamento->update(['situacao' => 'pendente', 'data_pagamento' => null]);

        return $lancamento;
    }

    public function cancelar(FinanceiroLancamento $lancamento): FinanceiroLancamento
    {
        $this->impedirAlteracaoDePagamento($lancamento);

        $lancamento->update(['situacao' => 'cancelado', 'data_pagamento' => null]);

        return $lancamento;
    }

    /**
     * Saldo realizado: receitas menos despesas pagas até a data informada.
     * Transferências não alteram o saldo total.
     */
    public function saldo(?int $contaId = null, $ate = null): float
    {
        $query = FinanceiroLancamento::pagos()
            ->when($contaId, fn ($q) => $q->where('conta_id', $contaId))
            ->when($ate, fn ($q) => $q->whereDate('data_pagamento', '<=', Carbon::parse($ate)->toDateString()));

        return (float) $query->sum(DB::raw("CASE WHEN tipo = 'receita' THEN valor WHEN tipo = 'despesa' THEN -valor ELSE 0 END"));
    }

    /**
     * Receitas e despesas pagas no período, pela data de pagamento.
     *
     * @return array{receitas: float, despesas: float}
     */
    public function totaisDoPeriodo($inicio, $fim): array
    {
        $totais = FinanceiroLancamento::pagos()
            ->whereDate('data_pagamento', '>=', Carbon::parse($inicio)->toDateString())
            ->whereDate('data_pagamento', '<=', Carbon::parse($fim)->toDateString())
            ->selectRaw("COALESCE(SUM(CASE WHEN tipo = 'receita' THEN valor ELSE 0 END), 0) AS receitas")
            ->selectRaw("COALESCE(SUM(CASE WHEN tipo = 'despesa' THEN valor ELSE 0 END), 0) AS despesas")
            ->first();

        return [
            'receitas' => (float) $totais->receitas,
            'despesas' => (float) $totais->despesas,
        ];
    }

    /**
     * Cria ou atualiza a receita correspondente a um pagamento de associado.
     * Só entra no saldo quando o pagamento está com status "pago".
     */
    public function sincronizarPagamento(Pagamento $pagamento): FinanceiroLancamento
    {
        $pago = $pagamento->status === 'pago';
        $tipoPagamento = $pagamento->tipo ?: 'mensalidade';
        $nomeCategoria = ucfirst($tipoPagamento);

        $categoria = FinanceiroCategoria::firstOrCreate(
            ['nome' => $nomeCategoria, 'tipo' => 'receita'],
            ['descricao' => 'Criada automaticamente para os pagamentos de associados']
        );

        $mes = $pagamento->mes_referencia?->format('m/Y');
        $nome = $pagamento->associado_nome ?: $pagamento->associado?->nome;

        return FinanceiroLancamento::updateOrCreate(
            ['origem' => FinanceiroLancamento::ORIGEM_PAGAMENTO, 'origem_id' => $pagamento->id],
            [
                'tipo' => 'receita',
                'valor' => $pagamento->valor,
                'data_lancamento' => $pagamento->data_pagamento,
                'data_vencimento' => null,
                'data_pagamento' => $pago ? $pagamento->data_pagamento : null,
                'situacao' => $pago ? 'pago' : 'pendente',
                'repeticao' => 'unica',
                'categoria_id' => $categoria->id,
                'categoria_nome' => $categoria->nome,
                'descricao' => trim("{$nomeCategoria} {$mes} - {$nome}", ' -'),
                'observacao' => $pagamento->observacao,
            ]
        );
    }

    public function removerPagamento(Pagamento $pagamento): void
    {
        FinanceiroLancamento::where('origem', FinanceiroLancamento::ORIGEM_PAGAMENTO)
            ->where('origem_id', $pagamento->id)
            ->delete();
    }

    // Guarda o nome da categoria para manter o histórico mesmo se ela for renomeada/excluída
    private function prepararDados(array $dados): array
    {
        if (array_key_exists('categoria_id', $dados)) {
            $dados['categoria_nome'] = $dados['categoria_id']
                ? FinanceiroCategoria::whereKey($dados['categoria_id'])->value('nome')
                : null;
        }

        return $dados;
    }

    private function impedirAlteracaoDePagamento(FinanceiroLancamento $lancamento): void
    {
        if ($lancamento->veioDePagamento()) {
            throw new DomainException('Este lançamento foi gerado por um pagamento de associado. Altere-o pela tela de pagamentos.');
        }
    }
}
