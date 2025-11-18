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
        Schema::table('alertas_status', function (Blueprint $table) {
            // Eliminar la columna 'estado' si existe (no se usa en la relación pivot)
            if (Schema::hasColumn('alertas_status', 'estado')) {
                $table->dropColumn('estado');
            }
        });
        
        Schema::table('alertas_status', function (Blueprint $table) {
            // Agregar columnas para la relación pivot entre alertas y usuarios
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('alert_id')->after('user_id');
            $table->integer('status')->default(0)->nullable()->after('alert_id'); // 0 = no leída, 1 = leída
        });
        
        Schema::table('alertas_status', function (Blueprint $table) {
            // Agregar índices para mejorar el rendimiento
            $table->index('user_id');
            $table->index('alert_id');
            $table->index(['user_id', 'alert_id']); // Índice compuesto
            
            // Agregar claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alert_id')->references('id')->on('alertas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alertas_status', function (Blueprint $table) {
            // Eliminar claves foráneas
            $table->dropForeign(['user_id']);
            $table->dropForeign(['alert_id']);
            
            // Eliminar índices
            $table->dropIndex(['user_id', 'alert_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['alert_id']);
            
            // Eliminar columnas
            $table->dropColumn(['user_id', 'alert_id', 'status']);
            
            // Restaurar columna 'estado' si era necesaria
            $table->string('estado')->after('id');
        });
    }
};
