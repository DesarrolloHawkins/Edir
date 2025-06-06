<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappEstadoMensajesTable extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_estado_mensajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('whatsapp_mensaje_id');
            $table->string('estado')->nullable();
            $table->string('recipient_id')->nullable();
            $table->timestamp('fecha_estado')->nullable();

            $table->foreign('whatsapp_mensaje_id')
                ->references('id')->on('whatsapp_mensajes')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_estado_mensajes');
    }
}
