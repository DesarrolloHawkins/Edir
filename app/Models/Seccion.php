<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = "secciones";

    protected $fillable = [
        "comunidad_id",
        "seccion_padre_id",
        "nombre",
        "ruta_imagen",
        "orden",
        'seccion_incidencias'
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function seccionPadre()
    {
        return $this->belongsTo(Seccion::class, 'seccion_padre_id');
    }

    public function seccionesHijas()
    {
        return $this->hasMany(Seccion::class, 'seccion_padre_id')->orderBy('orden', 'asc');
    }

    // Asumimos que hay una columna 'comunidad_id' en el modelo 'Seccion'
    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class);
    }

    // Una función para obtener la jerarquía considerando el 'comunidad_id'
    public function getHierarchy($comunidadId)
    {
        $sections = $this->with('seccionesHijas')
            ->where('comunidad_id', $comunidadId)
            ->where(function($query) {
                $query->whereNull('seccion_padre_id')
                      ->orWhere('seccion_padre_id', 0);
            })
            ->orderBy('orden', 'asc')
            ->get();

        return $sections->map(function ($seccion) {
            return $this->buildTree($seccion);
        });
    }

    // Función recursiva para construir el árbol
    private function buildTree($seccion)
    {
        $tree = ['seccion' => $seccion];

        if ($seccion->seccionesHijas->isNotEmpty()) {
            $tree['hijas'] = $seccion->seccionesHijas->map(function ($subSeccion) {
                return $this->buildTree($subSeccion);
            });
        }

        return $tree;
    }
}
