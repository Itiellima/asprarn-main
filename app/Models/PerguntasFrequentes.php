<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerguntasFrequentes extends Model
{
    protected $table = 'perguntas_frequentes';

    protected $fillable = [
        'titulo',
        'descricao',
    ];
}
