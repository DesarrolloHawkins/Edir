<?php

// database/migrations/xxxx_xx_xx_create_aviso_whatsapps_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvisoWhatsappsTable extends Migration
{
    public function up()
    {
        Schema::create('aviso_whatsapps', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('numero');
            $table->string('idioma'); // código API WhatsApp: es, en, fr...
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aviso_whatsapps');
    }
}

