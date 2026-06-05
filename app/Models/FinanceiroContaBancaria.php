<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceiroContaBancaria extends Model
{
    protected $table = 'financeiro_contas_bancarias';
    
    protected $fillable = [
        'nome',
        'tipo',
        'banco',
        'agencia',
        'conta',
        'descricao',
    ];
}
