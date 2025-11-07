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
        Schema::create('associado_situacao', function (Blueprint $table) {
            $table->id();

            $table->foreignId('associado_id')->constrained('associados')->onDelete('cascade');
            $table->foreignId('situacao_id')->constrained('situacoes')->onDelete('cascade');
            $table->boolean('ativo')->default(false);

            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associado_situacao');
    }
};
