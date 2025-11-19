<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Usar SQL directo para asegurar que la columna sea nullable
        DB::statement('ALTER TABLE alertas MODIFY COLUMN comunidad_id INTEGER NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revertir: hacer comunidad_id no nullable (cuidado con datos existentes)
        DB::statement('ALTER TABLE alertas MODIFY COLUMN comunidad_id INTEGER NOT NULL');
    }
};
