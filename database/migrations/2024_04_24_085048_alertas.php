<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alertas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id(); // id (bigint, auto_increment)
            $table->unsignedBigInteger('admin_user_id'); // admin_user_id
            $table->string('titulo', 191); // titulo
            $table->integer('tipo'); // tipo
            $table->dateTime('datetime'); // datetime
            $table->string('descripcion', 191)->nullable(); // descripcion
            $table->string('ruta_archivo', 191)->nullable(); // ruta_archivo
            $table->string('url', 191)->nullable(); // url
            $table->timestamps(); // created_at, updated_at
            $table->timestamp('deleted_at')->nullable(); // deleted_at
            $table->unsignedBigInteger('user_id'); // user_id
            $table->integer('comunidad_id'); // comunidad_id
            $table->integer('seccion_id'); // seccion_id

            // Opcional: Llaves foráneas
            // $table->foreign('admin_user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('your_table_name');
    }
}
