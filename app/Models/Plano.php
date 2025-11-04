<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    public function associados()
    {
        return $this->belongsToMany(Associado::class, 'associado_plano')
                ->withPivot(['data_inicio', 'data_fim', 'ativo'])
                ->withTimestamps();
    }

    protected $fillable = [
        'nome',
        'descricao',
        'beneficios',
        'ativo',
        'preco',
        'historico'
    ];
}
