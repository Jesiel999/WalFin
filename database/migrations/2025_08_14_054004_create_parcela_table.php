<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parcela', function (Blueprint $table){
            $table->integer('par_codclie')->nullable();
            $table->increments('par_codigo');
            $table->integer('par_codigomov');
            $table->decimal('par_valor');
            $table->integer('par_numero');
            $table->integer('par_qtnumero');
            $table->date('par_datavenc');
            $table->date('par_databaixa');
            $table->string('par_situacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcela');
    }
};
