<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComoNosEncontrou extends Model
{
    //
    protected $table = 'como_nos_encontrou';

    protected $fillable = [
        'associado_id',
        'nome',
        'descricao',
        'indicacao',
    ];
}
