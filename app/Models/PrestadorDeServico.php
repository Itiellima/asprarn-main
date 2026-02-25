<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestadorDeServico extends Model
{
    //
    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'empresa',
        'funcao',
        'departamento',
        'atividade',
        'email_pessoal',
        'email_profissional',
        'telefone_1',
        'telefone_2',
        'endereco',
        'data_admissao',
        'data_demissao',
        'observacoes'
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
