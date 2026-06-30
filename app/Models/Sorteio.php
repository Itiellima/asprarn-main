<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sorteio extends Model
{
    protected $fillable = [
        'numero',
        'descricao',
        'data_sorteio',
        'status',
        'created_by',
    ];

    public function participantes()
    {
        return $this->hasMany(SorteioParticipante::class);
    }

    public function resultados()
    {
        return $this->hasMany(SorteioResultado::class);
    }

}
