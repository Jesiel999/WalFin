<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('usua_codigo'); 
            $table->string('usua_grupo');
            $table->string('usua_nome');
            $table->string('usua_senha');
            $table->string('usua_cpfpj', 20);
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }

};
