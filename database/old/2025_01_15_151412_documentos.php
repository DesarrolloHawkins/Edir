<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id(); // Campo ID auto incrementado
            $table->unsignedBigInteger('comunidad_id')->nullable(); // Relación con la comunidad
            $table->string('nombre')->nullable(); // Nombre del documento
            $table->string('ruta_imagen')->nullable(); // Ruta de la imagen
            $table->string('seccion_incidencias')->nullable(); // Sección de incidencias (puede ser nulo)
            $table->date('fecha')->nullable(); // Fecha del documento (puede ser nulo)
            $table->timestamps(); // created_at y updated_at
            $table->softDeletes(); // deleted_at para borrado suave

            // Si hay relación con otra tabla, puedes añadir la clave foránea:
            $table->foreign('comunidad_id')->references('id')->on('comunidad')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
