<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consentimiento extends Model
{
    /** @use HasFactory<\Database\Factories\ConsentimientoFactory> */
    use HasFactory;

    protected $table = 'consentimientos';

    protected $fillable = [
        'visitante_id',
        'politica_id',
        'acepta',
        'fecha_aceptacion',
        'ip',
        'user_agent'
    ];

    public function visitante()
    {
        return $this->belongsTo(Visitantes::class, "visitante_id", "id");
    }
    public function politica()
    {
        return $this->belongsTo(PoliticaPrivacidad::class, 'politica_id', 'id');
    }
}
