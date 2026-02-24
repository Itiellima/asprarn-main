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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('rg')->nullable();
            $table->string('pis')->nullable();
            $table->string('ctps')->nullable();

            $table->string('empresa')->nullable();
            $table->string('funcao')->nullable();
            $table->string('departamento')->nullable();
            $table->string('atividade')->nullable();
            $table->string('horario_trabalho')->nullable();
            
            $table->string('email_pessoal')->nullable();
            $table->string('email_profissional')->nullable();
            $table->string('telefone_1')->nullable();
            $table->string('telefone_2')->nullable();
            
            $table->string('endereco')->nullable();

            $table->date('data_admissao')->nullable();
            $table->date('data_demissao')->nullable();
            $table->string('observacoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
