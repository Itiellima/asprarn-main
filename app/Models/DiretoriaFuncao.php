<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiretoriaFuncao extends Model
{
    protected $table = 'diretoria_funcoes';

    protected $fillable = [
        'nome',
        'descricao',
        'status',
    ];


}
