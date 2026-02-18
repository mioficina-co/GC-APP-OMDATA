<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    protected $table = 'eps';
    protected $fillable = ['nombre', 'descripcion'];
    public function visitantes()
    {
        return $this->hasMany(Visitantes::class, 'eps_id');
    }
}
