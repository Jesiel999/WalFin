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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->increments('paga_codigo');
            $table->unsignedBigInteger('paga_codassi');
            $table->string('paga_gateway_id')->nullable();
            $table->decimal('paga_valor', 10, 2);
            $table->string('paga_status')->default('pendente');
            $table->json('paga_detalhes')->nullable();
            $table->timestamps();

            $table->foreign('paga_codassi')->references('assi_codigo')->on('assinaturas');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
