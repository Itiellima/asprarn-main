<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceiroContasAPagar extends Model
{
    protected $table = 'contas_a_pagar';

    protected $fillable = [
        'tipo',
        'valor',
        'data_lancamento',
        'data_vencimento',
        'data_pagamento',
        'repeticao',
        'categoria_id',
        'categoria',
        'conta_id',
        'pago',
        'descricao',
        'observacao'
    ];
    
}
