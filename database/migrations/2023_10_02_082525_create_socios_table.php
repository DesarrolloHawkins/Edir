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
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('club_id');
            $table->boolean('situacion_persona')->nullable();
            $table->boolean('situacion_barco')->nullable();
            $table->integer('numero_socio')->nullable();
            $table->string('nombre_socio')->nullable();
            $table->string('dni')->nullable();
            $table->string('direccion')->nullable();
            $table->integer('telefono_1')->nullable();
            $table->integer('telefono_2')->nullable();
            $table->integer('telefono_3')->nullable();
            $table->string('email')->nullable();
            $table->string('pantalan_t_atraque')->nullable();
            $table->string('nombre_barco')->nullable();
            $table->string('matricula')->nullable();
            $table->decimal('eslora', 8, 2)->nullable();
            $table->decimal('manga', 8, 2)->nullable();
            $table->decimal('calado', 8, 2)->nullable();
            $table->bigInteger('numero_llave')->nullable();
            $table->string('seguro_barco')->nullable();
            $table->string('poliza')->nullable();
            $table->date('vencimiento')->nullable();
            $table->date('itb')->nullable();
            $table->string('ruta_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socios');
    }
};
