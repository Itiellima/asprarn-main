<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $casts = [
        'data' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    protected $fillable = [
        'user_id',
        'titulo',
        'texto',
        'assunto',
        'img',
        'owner',
        'data',
    ];

    protected static function booted()
    {
        static::deleting(function ($associado) {
            // Apaga arquivos da relação polimórfica
            foreach ($associado->files as $file) {
                if ($file->path && Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }
        });
    }
}
