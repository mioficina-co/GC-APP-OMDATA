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
        "genero",
        "compania",
        "placa_vehiculo",
        "nombre_contacto_emergencia",
        "numero_contacto_emergencia",
        "eps",
        "arl",
        "tipos_documento_id",
        "pais_id",
    ] ;

    public function visitas(){
        return $this->hasMany(visitantes::class, "visitante_id","id") ;
    }

    public function tiposDocumento(){
        return $this->belongsTo(tiposDocumento::class);
    }
}
