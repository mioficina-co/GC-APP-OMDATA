<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visitas extends Model
{

    protected $fillable = [
        "visitante_id",
        "empleado_id",
        "razon_id",
        "departamento_id",
        "fecha_inicio",
        "fecha_fin",
        "total_visitantes",
        "foto",
        "firma_base64",
        "acepta_politica",
        "pertenencias",
    ];
    //
    public function visitante(){
        return $this->belongsTo(visitantes::class, "visitante_id","id");
    }

    public function empleados(){
        return $this->belongsTo(empleados::class,"empleado_id","id");
    }

    public function departamentos(){
        return $this->belongsTo(departamentos::class ,"departamento_id","id");
    }

    public function razonvisita(){
        return $this->belongsTo(razonvisita::class);
    }

    public function paises(){
        return $this->belongsTo(paises::class);
    }
}
