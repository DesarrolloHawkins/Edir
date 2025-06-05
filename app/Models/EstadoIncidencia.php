<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoIncidencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estado_incidencias';

    protected $fillable = [
        'nombre',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

      /**
     * Relación con Incidencia.
     * Un estado tiene muchas incidencias.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'estado_id');
    }
}
