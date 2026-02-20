<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivos extends Model
{
    /** @use HasFactory<\Database\Factories\ArchivosFactory> */
    use HasFactory;

    protected $table = 'archivos';

    protected $fillable = [
        'visitante_id',
        'visita_id',
        'tipo',
        'ruta',
        'nombre_original',
        'mime_type'
    ];

    public function visitante()
    {
        return $this->belongsTo(Visitantes::class, "visitante_id", "id");
    }
    public function visita()
    {
        return $this->belongsTo(Visitas::class, "visita_id", "id");
    }
}
