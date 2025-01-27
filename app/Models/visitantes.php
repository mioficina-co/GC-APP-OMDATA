<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visitantes extends Model
{
    //

    protected $table = "visitantes";

    protected $fillable = [
        "nombre",
        "apellido",
        "numero_documento",
        "telefono",
        "email",
        "compania",
        "placa_vehiculo",
        "nombre_contacto_emergencia",
        "numero_contacto_emergencia",
        "eps_id",
        "arl_id",
        "tipos_documento_id",
        "pais_id",
        "activo"
    ];

    public function visitas(){
        return $this->hasMany(visitas::class, "visitante_id","id") ;
    }

    public function tiposDocumento(){
        return $this->belongsTo(tiposDocumento::class);
    }

    public function eps(){
        return $this->belongsTo(eps::class);
    }

    public function arl(){
        return $this->belongsTo(arl::class);
    }
}
