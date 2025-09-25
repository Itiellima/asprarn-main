<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoSituacoes extends Model
{
    public function associado() {
        return $this->belongsTo(Associado::class);
    }

    protected $fillable = [
        'associado_id',
        'situacao',
        'observacao',
        'data_inicio',
        'data_fim',
    ];
}
