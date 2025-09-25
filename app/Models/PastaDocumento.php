<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PastaDocumento extends Model
{

    protected $table = 'pasta_documentos';
    protected $fillable = [
        'associado_id',
        'nome',
        'tipo_documento',
        'descricao'
    ];


    //Uma pasta pertence a um associado
    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    //Uma pasta pode ter muitos documentos
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    protected static function booted()
    {
        static::deleting(function ($pastaDocumento) {
            // Apaga arquivos da relação polimórfica
            foreach ($pastaDocumento->files as $file) {
                if ($file->path && Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }
        });
    }
}
