<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiretoriaMembro extends Model
{
    protected $fillable = [
        'associado_id',
        'diretoria_id',
        'diretoria_funcao_id',
        'inicio_mandato',
        'fim_mandato',
        'ativo'
    ];


    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    public function diretoria()
    {
        return $this->belongsTo(Diretoria::class);
    }

    public function diretoria_funcao()
    {
        return $this->belongsTo(DiretoriaFuncao::class);
    }

}
