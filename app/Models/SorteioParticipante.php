<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SorteioParticipante extends Model
{
    protected $fillable = [
        'sorteio_id',
        'associado_id',
        'nome',
        'cpf',
        'habilitado',
    ];

    public function sorteio()
    {
        return $this->belongsTo(Sorteio::class);
    }

    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

}
