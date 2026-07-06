<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceiroContasAPagar extends Model
{
    protected $table = 'financeiro_contas_a_pagar';

    protected $casts = [
        'data_lancamento' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento'  => 'date',
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
        'pago',
        'descricao',
        'observacao'
    ];

    public function categoria()
    {
        return $this->belongsTo(FinanceiroCategoria::class, 'categoria_id');
    }

    public function conta()
    {
        return $this->belongsTo(FinanceiroContaBancaria::class, 'conta_id');
    }

}
