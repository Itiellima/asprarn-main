<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Lançamento financeiro. Contas a pagar são despesas e contas a receber são
 * receitas; enquanto não forem pagas ficam com situação "pendente".
 * Só lançamentos "pago" entram no saldo, pela data de pagamento.
 */
class FinanceiroLancamento extends Model
{
    public const ORIGEM_MANUAL = 'manual';
    public const ORIGEM_PAGAMENTO = 'pagamento';

    protected $table = 'financeiro_lancamentos';

    protected $casts = [
        'valor' => 'decimal:2',
        'data_lancamento' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
    ];

    protected $attributes = [
        'situacao' => 'pendente',
        'repeticao' => 'unica',
        'origem' => self::ORIGEM_MANUAL,
    ];

    protected $fillable = [
        'tipo',
        'valor',
        'data_lancamento',
        'data_vencimento',
        'data_pagamento',
        'repeticao',
        'categoria_id',
        'categoria_nome',
        'conta_id',
        'situacao',
        'descricao',
        'observacao',
        'origem',
        'origem_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(FinanceiroCategoria::class, 'categoria_id');
    }

    public function conta()
    {
        return $this->belongsTo(FinanceiroContaBancaria::class, 'conta_id');
    }

    public function scopePagos(Builder $query): Builder
    {
        return $query->where('situacao', 'pago');
    }

    public function scopePendentes(Builder $query): Builder
    {
        return $query->where('situacao', 'pendente');
    }

    // Pendentes primeiro, depois pagos e cancelados (funciona em MySQL e SQLite)
    public function scopeOrdenadosPorSituacao(Builder $query): Builder
    {
        return $query->orderByRaw("CASE situacao WHEN 'pendente' THEN 0 WHEN 'pago' THEN 1 ELSE 2 END");
    }

    // Gerado por um pagamento de mensalidade: deve ser editado pelo pagamento, não pelo financeiro
    public function veioDePagamento(): bool
    {
        return $this->origem === self::ORIGEM_PAGAMENTO;
    }
}
