<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromptAsistenteTable extends Migration
{
    public function up()
    {
        Schema::create('prompt_asistente', function (Blueprint $table) {
            $table->id();
            $table->text('prompt');
            $table->timestamps();
            $table->softDeletes(); // para usar SoftDeletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('prompt_asistente');
    }
}
