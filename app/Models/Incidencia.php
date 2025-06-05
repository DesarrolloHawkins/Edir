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
        "estado_id",
        "user_id",
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
        'created_at', 'updated_at', 'deleted_at', 'fecha',
    ];

    /**
     * Relación con EstadoIncidencia.
     * Una incidencia pertenece a un estado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo(EstadoIncidencia::class, 'estado_id');
    }

    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class, 'comunidad_id');
    }

    /**
     * Relación con Users.
     * Un usuario pertenece a Users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
