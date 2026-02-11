<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    //
    public function visitas(){
        return $this->hasMany(Visitas::class);
    }

    public function empleados(){
        return $this->hasMany(Empleados::class, "departamento_id" ,"id");
    }
}
