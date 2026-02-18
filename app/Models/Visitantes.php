<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitantes extends Model
{
    use SoftDeletes;

    protected $table = "visitantes";

    protected $fillable = [
        "nombre",
        "apellido",
        "tipos_documento_id",
        "numero_documento",
        "rh",
        "telefono",
        "email",
        "compania",
        "placa_vehiculo",
        "nombre_contacto_emergencia",
        "numero_contacto_emergencia",
        "activo",
        "fecha_aceptacion_politica",
        "politica_aceptada_id",
        "ip_aceptacion",
        "user_agent_aceptacion",
        "pais_id",
        "eps_id",
        "arl_id",
        "tipos_documento_id",
        "created_by",
        "updated_by",
        "deleted_by"
    ];

    public function visitas()
    {
        return $this->hasMany(Visitas::class, "visitante_id", "id");
    }

    public function archivos()
    {
        return $this->hasMany(Archivos::class, "visitante_id", "id");
    }

    public function consentimientos()
    {
        return $this->hasMany(Consentimiento::class, "visitante_id", "id");
    }

    public function tiposDocumento()
    {
        return $this->belongsTo(TiposDocumento::class, "tipos_documento_id", "id");
    }

    public function eps()
    {
        return $this->belongsTo(Eps::class, "eps_id", "id");
    }

    public function arl()
    {
        return $this->belongsTo(Arl::class, "arl_id", "id");
    }

    public function politicaAceptada()
    {
        return $this->belongsTo(PoliticaPrivacidad::class, "politica_aceptada_id", "id");
    }

    //relaciones para recuperar automaticamente la ultima visita y foto
    //de un visitante

    /**
     * Obtiene la última visita registrada (Relación eficiente)
     */
    public function ultimaVisita()
    {
        return $this->hasOne(Visitas::class, 'visitante_id', 'id')->latestOfMany();
    }

    /**
     * Obtiene la última foto registrada (Relación eficiente)
     */
    public function ultimaFoto()
    {
        return $this->hasOne(Archivos::class, 'visitante_id', 'id')->ofMany([
            'id' => 'max'
        ], function ($query) {
            $query->where('tipo', 'foto');
        });
    }
}
