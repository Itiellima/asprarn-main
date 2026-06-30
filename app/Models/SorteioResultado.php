<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SorteioResultado extends Model
{
    protected $fillable = [
        'sorteio_id',
        'sorteio_participante_id',
        'posicao',
        'premio',
    ];

    public function sorteio()
    {
        return $this->belongsTo(Sorteio::class);
    }

    public function participante()
    {
        return $this->belongsTo(SorteioParticipante::class, 'sorteio_participante_id');
    }

}
