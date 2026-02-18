<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitas extends Model
{

    use SoftDeletes;

    protected $fillable = [
        "visitante_id",
        "empleado_id",
        "razon_id",
        "otra_razon_visita",
        "departamento_id",
        "fecha_inicio",
        "fecha_fin",
        "total_visitantes",
        "pertenencias",
        "created_by",
        "updated_by",
        "deleted_by"
    ];
    //
    public function visitante()
    {
        return $this->belongsTo(Visitantes::class, "visitante_id", "id");
    }

    public function empleados()
    {
        return $this->belongsTo(Empleados::class, "empleado_id", "id");
    }

    public function departamentos()
    {
        return $this->belongsTo(Departamentos::class, "departamento_id", "id");
    }

    public function razonvisita()
    {
        return $this->belongsTo(RazonVisita::class, "razon_id", "id");
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, "pais_id", "id");
    }

    // Relación para obtener foto y firma de esta visita específica
    public function archivos()
    {
        return $this->hasMany(Archivos::class, 'visita_id', 'id');
    }
}
