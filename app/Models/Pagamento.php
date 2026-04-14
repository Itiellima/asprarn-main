<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    //
    protected $fillable = [
        'associado_id',
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

    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
