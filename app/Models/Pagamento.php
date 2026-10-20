<?php

namespace App\Models;

use App\Services\Financeiro\LancamentoService;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    //
    protected $fillable = [
        'associado_id',
        'associado_nome',
        'associado_cpf',
        'valor',
        'data_pagamento',
        'mes_referencia',
        'metodo_pagamento',
        'tipo',
        'status',
        'numero_documento',
        'origem',
        'user_id',
        'observacao',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_pagamento' => 'date',
        'mes_referencia' => 'date',
    ];

    protected static function booted()
    {
        // Mantém a receita do financeiro sempre igual ao pagamento
        static::saved(function (Pagamento $pagamento) {
            app(LancamentoService::class)->sincronizarPagamento($pagamento);
        });

        static::deleted(function (Pagamento $pagamento) {
            app(LancamentoService::class)->removerPagamento($pagamento);
        });
    }

    public function lancamento()
    {
        return $this->hasOne(FinanceiroLancamento::class, 'origem_id')
            ->where('origem', FinanceiroLancamento::ORIGEM_PAGAMENTO);
    }

    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
