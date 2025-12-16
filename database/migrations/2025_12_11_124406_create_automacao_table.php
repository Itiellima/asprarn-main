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
        Schema::create('automacao', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('mensagem');
            $table->date('data_inicio');
            $table->date('ultima_execucao')->nullable();
            $table->integer('intervalo_dias')->nullable();
            $table->integer('repetir_dias')->nullable();
            $table->boolean('ativo')->default(true);
            $table->foreignId('situacao_id')->constrained('situacoes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automacao');
    }
};
