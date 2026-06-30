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
        Schema::create('sorteio_resultados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sorteio_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sorteio_participante_id')->constrained()->cascadeOnDelete();

            $table->unique(['sorteio_id', 'sorteio_participante_id']);
            
            $table->integer('posicao')->nullable();
            $table->string('premio')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorteio_resultados');
    }
};
