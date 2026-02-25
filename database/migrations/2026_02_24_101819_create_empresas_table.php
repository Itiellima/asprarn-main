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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cnpj')->nullable();
            $table->string('endereco')->nullable();
            $table->string('telefone')->nullable();
            $table->string('telefone_2')->nullable();

            $table->string('email')->nullable();
            $table->string('email_2')->nullable();
            
            $table->string('tipo_convenio')->nullable();
            $table->string('horario_trabalho')->nullable();

            $table->date('data_inicio_contrato')->nullable();
            $table->date('data_fim_contrato')->nullable();
            
            $table->text('funcionarios')->nullable();
            $table->string('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
