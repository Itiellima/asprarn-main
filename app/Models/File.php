<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'path',
        'tipo_documento',
        'status',
        'observacao',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    // Facilitar a recuperação da URL pública:
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    protected static function booted()
    {
        static::deleting(function ($file) {
            // Deleta o arquivo físico ao deletar o registro no banco
            if ($file->path && Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }

            // Pega o diretório do arquivo
            $directory = dirname($file->path);

            // Se não houver mais arquivos nem subpastas → remove o diretório
            if (
                empty(Storage::disk('public')->files($directory)) &&
                empty(Storage::disk('public')->directories($directory))
            ) {
                Storage::disk('public')->deleteDirectory($directory);
            }
        });
    }
}
