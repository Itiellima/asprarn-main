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
        Schema::create('situacaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('associado_id')->constrained('associados')->onDelete('cascade');
            $table->boolean('ativo')->default(0);
            $table->boolean('inadimplente')->default(0);
            $table->boolean('pendente_documento')->default(0);
            $table->boolean('pendente_financeiro')->default(0);
            $table->string('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('situacao');
    }
};
