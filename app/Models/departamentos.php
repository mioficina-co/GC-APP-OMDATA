<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class departamentos extends Model
{
    //
    public function visitas(){
        return $this->hasMany(visitas::class);
    }

    public function empleados(){
        return $this->hasMany(empleados::class, "departamento_id" ,"id");
    }
}
