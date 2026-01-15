<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacoes';

    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }


    protected $fillable = [
        'titulo',
        'mensagem',
        'associado_id',
        'lida',
    ];
}
