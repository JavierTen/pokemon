<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    protected $table = 'favorites';

    protected $fillable = [
        'id_usuario',
        'ref_api',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_usuario');
    }

}
