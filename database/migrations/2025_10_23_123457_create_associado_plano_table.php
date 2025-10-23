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
        Schema::create('associado_plano', function (Blueprint $table) {
            $table->id();

            $table->foreignId('associado_id')->constrained('associados')->onDelete('cascade');
            $table->foreignId('plano_id')->constrained('planos')->onDelete('cascade');

            $table->date('data_inicio')->default(now());
            $table->date('data_fim')->nullable();
            $table->boolean('ativo')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associado_plano');
    }
};
