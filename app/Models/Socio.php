<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Socio extends Model
{
    use HasFactory;
    protected $table = "socios";

    protected $fillable = [
        'club_id',
        'situacion_persona',
        'situacion_barco',
        'numero_socio',
        'nombre_socio',
        'dni',
        'direccion',
        'telefono_1',
        'telefono_2',
        'telefono_3',
        'email',
        'pantalan_t_atraque',
        'nombre_barco',
        'matricula',
        'eslora',
        'manga',
        'calado',
        'numero_llave',
        'seguro_barco',
        'poliza',
        'vencimiento',
        'itb',
        'ruta_foto',
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Get all of the comments for the Socio
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notas(): HasMany
    {
        return $this->hasMany(Nota::class, 'socio_id');
    }
}
