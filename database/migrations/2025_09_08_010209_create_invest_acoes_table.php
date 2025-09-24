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
        Schema::create('invest', function (Blueprint $table) {
            $table->increments('inv_id');
            $table->string('inv_codigo', 45)->nullable();
            $table->string('inv_nome', 100)->nullable();
            $table->enum('inv_tipo', ['ACAO', 'FII', 'CRIPTO', 'RENDA_FIXA', 'ETF', 'OUTRO'])->nullable();
            $table->string('inv_bolsa', 50)->nullable();
            $table->string('inv_moeda', 10)->default('BRL');
            $table->decimal('inv_preco_atual', 18, 8)->nullable();
            $table->decimal('inv_variacao_dia', 10, 4)->nullable();
            $table->decimal('inv_variacao_12m', 10, 4)->nullable();
            $table->decimal('inv_dividend_yield', 10, 4)->nullable();
            $table->decimal('inv_patrimonio', 18, 2)->nullable();
            $table->decimal('inv_volume_medio', 18, 2)->nullable();
            $table->string('inv_risco', 50)->nullable();
            $table->string('inv_emissor', 255)->nullable();
            $table->date('inv_vencimento')->nullable();
            $table->decimal('inv_rentabilidade', 10, 4)->nullable();

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest');
    }
};
