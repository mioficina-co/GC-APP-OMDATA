<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    protected $table = 'paises';
    
    //
    public function visitas(){
        return $this->hasMany(Visitas::class);
    }
}
