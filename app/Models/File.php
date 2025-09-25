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
            if ($file->arquivo && Storage::disk('public')->exists($file->arquivo)) {
                Storage::disk('public')->delete($file->arquivo);
            }
        });
    }
}
