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
        Schema::create('diretoria_membros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('associado_id')->nullable()->constrained()->cascadeOnDelete();
            
            $table->foreignId('diretoria_funcoes_id')->nullable()->constrained()->cascadeOnDelete();

            $table->foreignId('diretoria_id')->nullable()->constrained()->cascadeOnDelete();

            $table->date('inicio_mandato')->nullable();
            $table->date('fim_mandato')->nullable();
            
            $table->boolean('ativo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diretoria_membros');
    }
};
