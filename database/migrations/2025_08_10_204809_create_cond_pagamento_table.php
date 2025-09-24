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
        Schema::create('cond_pagamento', function (Blueprint $table) {
            $table->integer('copa_codclie')->nullable();
            $table->increments('copa_codigo');
            $table->string('copa_nome', 45);
            $table->string('copa_desc');
            $table->string('copa_tipo', 45); // 'à vista' ou 'a prazo'
            $table->smallInteger('copa_intervalo')->nullable(); // dias entre parcelas
            $table->tinyInteger('copa_parcelas')->nullable(); // quantidade de parcelas
            $table->boolean('copa_status')->default(true); // ativo/inativo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cond_pagamento');
    }
};
