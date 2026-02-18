<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleados extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'departamento_id',
        'user_id',
        'activo',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    public function visitas(){
        return $this->hasMany(Visitas::class,"empleado_id","id");
    }

    public function departamentos(){
        return $this->belongsTo(Departamentos::class, 'departamento_id', 'id');
    }
}
