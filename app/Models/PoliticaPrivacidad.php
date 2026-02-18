<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoliticaPrivacidad extends Model
{
    /** @use HasFactory<\Database\Factories\PoliticaPrivacidadFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'politica_privacidads';

    protected $fillable = ['version', 'contenido', 'fecha_publicacion', 'activa', 'deleted_by'];

    public function consentimientos()
    {
        return $this->hasMany(Consentimiento::class, 'politica_id', 'id');
    }
}
