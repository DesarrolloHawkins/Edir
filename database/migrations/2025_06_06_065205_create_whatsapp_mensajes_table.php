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
        Schema::create('whatsapp_mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('mensaje_id')->unique();
            $table->string('tipo')->nullable();
            $table->text('contenido')->nullable();
            $table->string('remitente')->nullable();
            $table->string('estado')->nullable();
            $table->string('recipient_id')->nullable();
            $table->timestamp('fecha_mensaje')->nullable();
            $table->json('metadata')->nullable();
            $table->string('conversacion_id')->nullable();
            $table->string('origen_conversacion')->nullable();
            $table->timestamp('expiracion_conversacion')->nullable();
            $table->boolean('billable')->default(false);
            $table->string('categoria_precio')->nullable();
            $table->string('modelo_precio')->nullable();
            $table->json('errores')->nullable();
            $table->unsignedBigInteger('reply_to_id')->nullable();

            $table->foreign('reply_to_id')->references('id')->on('whatsapp_mensajes')->onDelete('set null');

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
        Schema::dropIfExists('whatsapp_mensajes');
    }
};
