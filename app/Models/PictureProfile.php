<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PictureProfile extends Model
{
    //
    protected $fillable = ['associado_id', 'path'];

    // URL da foto, servida pelo Laravel a partir do bucket de mídia
    public function getUrlAttribute()
    {
        return route('midia', ['path' => $this->path]);
    }

    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }
}
