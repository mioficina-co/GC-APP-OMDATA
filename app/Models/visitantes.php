<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitantes extends Model
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
        return $this->hasMany(Visitas::class, "visitante_id","id") ;
    }

    public function tiposDocumento(){
        return $this->belongsTo(TiposDocumento::class);
    }

    public function eps(){
        return $this->belongsTo(Eps::class);
    }

    public function arl(){
        return $this->belongsTo(Arl::class);
    }
}
