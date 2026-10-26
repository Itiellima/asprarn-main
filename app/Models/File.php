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

    /**
     * Disco onde o arquivo está guardado: documentos de associados no bucket
     * de documentos; imagens de posts, banners e benefícios no bucket de mídia.
     */
    public static function discoPara(string $fileableType): string
    {
        return $fileableType === PastaDocumento::class ? 'documentos' : 'midia';
    }

    public function disco(): string
    {
        return static::discoPara((string) $this->fileable_type);
    }

    // URL da imagem, servida pelo Laravel a partir do bucket de mídia
    public function getUrlAttribute()
    {
        return route('midia', ['path' => $this->path]);
    }

    protected static function booted()
    {
        static::deleting(function ($file) {
            if (!$file->path) {
                return;
            }

            $disco = Storage::disk($file->disco());

            // Deleta o arquivo físico ao deletar o registro no banco
            if ($disco->exists($file->path)) {
                $disco->delete($file->path);
            }
        });
    }
}
