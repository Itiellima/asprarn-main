<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    protected $fillable = [
        'cep',
        'logradouro',
        'nmr',
        'bairro',
        'cidade',
        'uf',
        'complemento',
        'associado_id'
    ];
}
