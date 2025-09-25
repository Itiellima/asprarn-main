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
        Schema::create('documento_associados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('associado_id')->constrained('associados')->onDelete('cascade');
            $table->string('tipo_documento'); // e.g., 'identidade', 'comprovante_residencia'
            $table->string('arquivo');
            $table->enum('status', ['pendente', 'recebido', 'rejeitado'])->default('pendente');
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_associados');
    }
};
