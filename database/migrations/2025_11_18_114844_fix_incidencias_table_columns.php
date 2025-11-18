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
        Schema::table('incidencias', function (Blueprint $table) {
            // Cambiar telefono de integer a string
            if (Schema::hasColumn('incidencias', 'telefono')) {
                $table->string('telefono')->nullable()->change();
            }
            
            // Hacer ruta_imagen nullable
            if (Schema::hasColumn('incidencias', 'ruta_imagen')) {
                $table->string('ruta_imagen')->nullable()->change();
            }
            
            // Agregar titulo si no existe
            if (!Schema::hasColumn('incidencias', 'titulo')) {
                $table->string('titulo')->after('id');
            }
            
            // Agregar descripcion si no existe
            if (!Schema::hasColumn('incidencias', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('titulo');
            }
            
            // Agregar url si no existe
            if (!Schema::hasColumn('incidencias', 'url')) {
                $table->string('url')->nullable()->after('descripcion');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            if (Schema::hasColumn('incidencias', 'titulo')) {
                $table->dropColumn('titulo');
            }
            if (Schema::hasColumn('incidencias', 'descripcion')) {
                $table->dropColumn('descripcion');
            }
            if (Schema::hasColumn('incidencias', 'url')) {
                $table->dropColumn('url');
            }
        });
    }
};
