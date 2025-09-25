<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Beneficio extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    protected static function booted()
    {
        static::deleting(function ($beneficio) {
            // Apaga arquivos da relação polimórfica
            foreach ($beneficio->files as $file) {
                if ($file->path && Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }
        });
    }
}
