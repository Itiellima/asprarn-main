<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensalidade extends Model
{
    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    protected $fillable = [
        'associado_id',
        'mes_referencia',
        'valor',
        'status',
        'data_pagamento',
        'observacao',
    ];
}
