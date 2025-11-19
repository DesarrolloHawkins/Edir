<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alertas extends Model
{
    use HasFactory;

    protected $table = "alertas";
    protected $fillable = [
        'admin_user_id',
        'titulo',
        'tipo',
        'datetime',
        'descripcion',
        'ruta_archivo',
        'url',
        'user_id',
        'comunidad_id',
        'seccion_id',

    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'alertas_status', 'alert_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class, 'comunidad_id');
    }
}
