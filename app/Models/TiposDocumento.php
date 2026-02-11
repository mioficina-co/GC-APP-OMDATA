<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposDocumento extends Model
{
    //
    protected $table = "tipos_documento";
    protected $fillable = [
        "nombre",
    ] ;
    public function visitante(){
        return $this->belongsTo(Visitantes::class);
    }
}
