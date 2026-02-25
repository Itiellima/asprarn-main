<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'telefone',
        'telefone_2',
        'email',
        'email_2',
        'tipo_convenio',
        'horario_trabalho',
        'data_inicio_contrato',
        'data_fim_contrato',
        'funcionarios',
        'observacoes'
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    
}
