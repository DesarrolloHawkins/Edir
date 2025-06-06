<?php 
// app/Models/AvisoWhatsapp.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisoWhatsapp extends Model
{
    protected $fillable = ['nombre', 'numero', 'idioma'];
}
