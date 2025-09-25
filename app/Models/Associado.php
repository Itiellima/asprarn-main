<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Associado extends Model
{
    // Um associado pertence a um usuario
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // Um associado tem um endereco, contato, dados bancarios e situacao.
    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }
    public function contato()
    {
        return $this->hasOne(Contato::class);
    }
    public function dadosBancarios()
    {
        return $this->hasOne(DadosBancarios::class);
    }
    public function situacao()
    {
        return $this->hasOne(Situacao::class);
    }

    // Um associado pode ter muitos documentos, mensalidades, historicoSituacoes e pastas de documentos.
    public function mensalidades()
    {
        return $this->hasMany(Mensalidade::class);
    }

    public function historicoSituacoes()
    {
        return $this->hasMany(HistoricoSituacoes::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function pastaDocumentos()
    {
        return $this->hasMany(PastaDocumento::class);
    }


    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'org_expedidor',
        'nome_pai',
        'nome_mae',
        'dt_nasc',
        'estado_civil',
        'grau_instrucao',
        'graduacao',
        'nome_guerra',
        'nmr_praca',
        'matricula',
        'opm',
        'dependentes',
        'obs'
    ];

    protected static function booted()
    {
        static::deleting(function ($associado) {
            foreach ($associado->documentos as $documento) {
                // Exclui o arquivo físico
                if ($documento->arquivo && Storage::disk('public')->exists($documento->arquivo)) {
                    Storage::disk('public')->delete($documento->arquivo);
                }

                // Exclui o registro no banco
                $documento->delete();
            }
        });
    }
}
