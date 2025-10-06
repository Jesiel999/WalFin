<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pessoa', function (Blueprint $table) {
            $table->increments('pes_codigo');
            $table->increments('pes_codclie');
            $table->string('pes_nome');
            $table->string('pes_cpfpj', 20);
            $table->string('pes_email');
            $table->integer('pes_telefone');
            $table->string('pes_observacao');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoa');
    }
};
