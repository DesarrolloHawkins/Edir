<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientosTable extends Migration
{
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('empresa')->nullable();
            $table->string('numero');
            $table->text('otros_cambios')->nullable();
            $table->json('disponibilidad')->nullable(); // JSON de días y horarios
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mantenimientos');
    }
}

