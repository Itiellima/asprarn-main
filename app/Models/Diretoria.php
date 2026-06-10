<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diretoria extends Model
{
    protected $table = 'diretorias';

    protected $fillable = [
        'nome',
        'sigla',
        'status'
    ];
}
