<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{

    public function associados()
    {
        return $this->belongsToMany(Associado::class, 'associado_situacao')
            ->withPivot(['data_inicio', 'data_fim', 'ativo'])
            ->withTimestamps();
    }

    public function automacoes()
    {
        return $this->hasMany(Automacao::class);
    }

    protected $table = 'situacoes'; // Aponta para a tabela 'Situacaos'

    protected $fillable = [
        'nome',
    ];
}
