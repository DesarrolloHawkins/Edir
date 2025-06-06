<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $fillable = [
        'nombre', 'empresa', 'numero', 'otros_cambios', 'disponibilidad'
    ];

    protected $casts = [
        'disponibilidad' => 'array',
    ];
}
