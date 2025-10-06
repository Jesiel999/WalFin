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
        Schema::create('assinaturas', function (Blueprint $table) {
        $table->bigIncrements('assi_codigo');
        $table->unsignedBigInteger('assi_codclie'); 
        $table->unsignedBigInteger('assi_codplan'); 
        $table->string('assi_status')->default('pendente');
        $table->date('assi_inicio')->nullable();
        $table->date('assi_fim')->nullable();
        $table->string('assi_gateway_id')->nullable();
        $table->timestamps();

        $table->foreign('assi_codclie')->references('usua_codigo')->on('usuario')->onDelete('cascade');
        $table->foreign('assi_codplan')->references('plan_codigo')->on('plano')->onDelete('cascade');
    });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinaturas');
    }
};
