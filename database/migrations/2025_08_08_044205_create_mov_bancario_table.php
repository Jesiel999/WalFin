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
        Schema::create('mov_bancario', function (Blueprint $table) {
            $table->integer('movb_codclie')->nullable();
            $table->string('movb_cliente', 45)->nullable();
            $table->integer('movb_codigo', true);
            $table->decimal('movb_valortotal', 11, 0);
            $table->decimal('movb_valorliquido', 11, 0);
            $table->string('movb_situacao', 45);
            $table->string('movb_categoria_id', 10)->nullable();
            $table->string('movb_categoria', 45)->nullable();
            $table->integer('movb_cpfpj')->nullable();
            $table->string('movb_pessoa', 45)->nullable();
            $table->string('movb_observ')->nullable();
            $table->date('movb_datavenc');
            $table->date('movb_databaixa');
            $table->date('movb_dataes');
            $table->string('movb_forma', 45);
            $table->string('movb_natureza', 45);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mov_bancario');
    }
};
