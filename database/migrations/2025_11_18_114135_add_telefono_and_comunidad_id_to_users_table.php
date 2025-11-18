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
        Schema::table('users', function (Blueprint $table) {
            // Cambiar telefono de integer a string si ya existe, o agregarlo si no existe
            if (Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono')->nullable()->change();
            } else {
                $table->string('telefono')->nullable()->after('email');
            }
            
            // Agregar comunidad_id si no existe
            if (!Schema::hasColumn('users', 'comunidad_id')) {
                $table->unsignedBigInteger('comunidad_id')->nullable()->after('telefono');
                $table->foreign('comunidad_id')->references('id')->on('comunidad')->onDelete('set null');
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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'comunidad_id')) {
                $table->dropForeign(['comunidad_id']);
                $table->dropColumn('comunidad_id');
            }
            // No revertir telefono a integer para evitar pérdida de datos
        });
    }
};
