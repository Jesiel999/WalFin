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
        Schema::create('plano', function (Blueprint $table) {
            $table->increments('plan_codigo');
            $table->string('plan_nome');
            $table->decimal('plan_valor', 10, 2);
            $table->integer('plan_duracao')->comment('em dias');
            $table->text('plan_descricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano');
    }
};
