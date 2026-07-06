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
        Schema::create('financeiro_contas_a_pagar', function (Blueprint $table) {
            $table->id();

            $table->enum('tipo', ['despesa', 'receita', 'transferencia',]);

            $table->decimal('valor', 10, 2);

            $table->date('data_lancamento');
            $table->date('data_vencimento')->nullable();
            $table->date('data_pagamento')->nullable();

            $table->enum('repeticao', ['diaria', 'semanal', 'quinzenal', 'mensal', 'anual', 'unica']);

            $table->foreignId('categoria_id')->nullable()->constrained('financeiro_categorias')->nullOnDelete();
            $table->string('categoria_nome')->nullable();

            $table->foreignId('conta_id')->nullable()->constrained('financeiro_contas_bancarias')->nullOnDelete();

            $table->boolean('pago')->default(false);

            $table->string('descricao')->nullable();

            $table->text('observacao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro_contas_a_pagar');
    }
};
