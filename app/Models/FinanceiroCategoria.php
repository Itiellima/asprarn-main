<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceiroCategoria extends Model
{
    protected $table = 'financeiro_categorias';

    protected $fillable = [
        'nome',
        'tipo',
        'descricao',
    ];
}
