<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;
    protected $table = "incidencias";

    protected $fillable = [
        "comunidad_id",
        "titulo",
        "descripcion",
        "fecha",
        "ruta_imagen",
        "url",
        "nombre",
        "telefono"
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
