<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    use HasFactory;
    protected $table = "comunidad";

    protected $fillable = [
        "user_id",
        "nombre",
        "direccion",
        "ruta_imagen",
        "informacion_adicional",
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'comunidad_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
