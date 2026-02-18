<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RazonVisita extends Model
{
    //

    protected $table = 'razonvisitas';
    public function visitas()
    {
        return $this->hasMany(Visitas::class);
    }
}
