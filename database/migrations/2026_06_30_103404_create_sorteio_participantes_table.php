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
        Schema::create('sorteio_participantes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sorteio_id')->constrained()->cascadeOnDelete();
            $table->foreignId('associado_id')->nullable()->constrained()->nullOnDelete();

            $table->string('nome')->nullable();
            $table->string('cpf')->nullable();

            $table->boolean('habilitado')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorteio_participantes');
    }
};
