<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opm extends Model
{
    //

    public $table = 'opms';

    protected $fillable = [
        'nome',
        'descricao',
        'status',
    ];
    
}
