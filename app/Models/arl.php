<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class arl extends Model
{
    protected $table = 'arl';
    protected $fillable = ['nombre', 'descripcion'];

    public function visitantes(){
        return $this->hasMany(Visitantes::class, 'arl_id');
    }
}
