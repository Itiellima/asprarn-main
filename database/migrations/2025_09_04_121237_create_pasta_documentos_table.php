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
        Schema::create('pasta_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('associado_id');
            $table->string('nome'); // Nome da pasta
            $table->string('tipo_documento')->nullable();
            $table->text('descricao')->nullable();
            $table->timestamps();
            $table->foreign('associado_id')->references('id')->on('associados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasta_documentos');
    }
};
