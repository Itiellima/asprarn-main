<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    //
    protected $fillable = [
        'titulo',
        'descricao',
    ];
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    protected static function booted()
    {
        static::deleting(function ($banner) {
            // Exclui o arquivo da relação polimórfica
            foreach ($banner->files as $file) {
                if ($file->path && Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }
        });
    }
}
