<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PictureProfile extends Model
{
    //
    protected $fillable = ['associado_id', 'path'];

    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }
}
