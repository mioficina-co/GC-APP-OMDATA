<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class empleados extends Model
{
    //

    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'departamento_id',
    ];
    public function visitas(){
        return $this->hasMany(Visitas::class,"empleado_id","id");
    }

    public function departamentos(){
        return $this->belongsTo(departamentos::class, 'departamento_id', 'id');
    }
}
