<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiretoriaMembro extends Model
{
    protected $fillable = [
        'associado_id',
        'diretoria_id',
        'diretoria_funcoes_id',
        'inicio_mandato',
        'fim_mandato',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];


    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    public function diretoria()
    {
        return $this->belongsTo(Diretoria::class);
    }

    public function funcao()
    {
        return $this->belongsTo(DiretoriaFuncao::class, 'diretoria_funcoes_id');
    }

}
