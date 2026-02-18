<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaDatos extends Model
{
    /** @use HasFactory<\Database\Factories\AuditoriaDatosFactory> */
    use HasFactory;

    protected $table = 'auditoria_datos';
    protected $fillable = [
        'user_id',
        'evento',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip',
        'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
}
