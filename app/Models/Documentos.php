<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;
    protected $table = "documentos";

    protected $fillable = [
        "comunidad_id",
        'seccion_id',
        "nombre",
        "ruta_imagen",
        'seccion_incidencias',
        'fecha'
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

}
