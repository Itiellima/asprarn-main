<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcaoJudicial extends Model
{
    //
    protected $table = 'acao_judicial';

    protected $fillable = [
        'nome',
        'descricao',
        'data_inicio',
        'data_fim',
        'status',
    ];

    public function associados()
    {
        return $this->belongsToMany(Associado::class, 'acao_judicial_associado', 'acao_judicial_id', 'associado_id')
            ->withTimestamps();
    }

}
