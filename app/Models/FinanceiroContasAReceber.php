<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceiroContasAReceber extends Model
{
    protected $table = 'financeiro_contas_a_receber';

    protected $casts = [
        'data_lancamento' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
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
