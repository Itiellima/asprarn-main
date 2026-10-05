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
     * Disco onde o arquivo está guardado: documentos de associados ficam
     * no bucket privado; imagens de posts, banners etc. no disco público.
     */
    public static function discoPara(string $fileableType): string
    {
        return $fileableType === PastaDocumento::class ? 'documentos' : 'public';
    }

    public function disco(): string
    {
        return static::discoPara((string) $this->fileable_type);
    }

    // Facilitar a recuperação da URL pública:
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
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

            // No bucket (S3) não existem diretórios de verdade; a limpeza é só no disco local
            if ($file->disco() !== 'public') {
                return;
            }

            // Pega o diretório do arquivo
            $directory = dirname($file->path);

            // Se não houver mais arquivos nem subpastas → remove o diretório
            if (
                empty($disco->files($directory)) &&
                empty($disco->directories($directory))
            ) {
                $disco->deleteDirectory($directory);
            }
        });
    }
}
