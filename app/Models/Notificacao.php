<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacoes';

    protected $fillable = [
        'titulo',
        'mensagem',
        'associado_id',
        'lida',
    ];
}
