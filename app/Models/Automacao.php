<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Automacao extends Model
{
    //
    protected $table = 'automacao';

    protected $fillable = [
        'nome',
        'mensagem',
        'data_inicio',
        'intervalo_dias',
        'repetir_dias',
        'ativo',
        'situacao_id',
        'ultima_execucao',
    ];

    public function situacao()
    {
        return $this->belongsTo(Situacao::class);
    }
}
