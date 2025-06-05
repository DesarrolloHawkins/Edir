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
        Schema::create('estado_incidencias', function (Blueprint $table) {
            $table->id(); // Clave primaria auto incrementada
            $table->string('nombre'); // Nombre del estado
            $table->timestamps(); // created_at y updated_at
            $table->softDeletes(); // deleted_at para borrado suave
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado_incidencias');
    }
};
