<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Contas a pagar e a receber passam a ser lançamentos (despesa/receita pendentes)
 * em financeiro_lancamentos. As tabelas separadas e a antiga financeiro_lacamentos
 * (nome com erro de digitação, sem uso) são removidas.
 *
 * Os dados dessas tabelas são descartados: o financeiro ainda não estava em uso.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('financeiro_contas_a_pagar');
        Schema::dropIfExists('financeiro_contas_a_receber');
        Schema::dropIfExists('financeiro_lacamentos');

        // Padroniza a origem: "manual" (cadastrado no financeiro) ou "pagamento" (mensalidade)
        DB::table('financeiro_lancamentos')->whereNull('origem')->orWhere('origem', 'Manual')->update(['origem' => 'manual']);
        DB::table('financeiro_lancamentos')->where('origem', 'mensalidade_associado')->update(['origem' => 'pagamento']);

        Schema::table('financeiro_lancamentos', function (Blueprint $table) {
            $table->string('origem')->default('manual')->change();
            $table->index(['origem', 'origem_id']);
            $table->index(['situacao', 'data_pagamento']);
        });
    }

    public function down(): void
    {
        Schema::table('financeiro_lancamentos', function (Blueprint $table) {
            $table->dropIndex(['origem', 'origem_id']);
            $table->dropIndex(['situacao', 'data_pagamento']);
            $table->string('origem')->nullable()->default('Manual')->change();
        });

        foreach (['financeiro_contas_a_pagar', 'financeiro_contas_a_receber'] as $tabela) {
            Schema::create($tabela, function (Blueprint $table) {
                $table->id();
                $table->enum('tipo', ['despesa', 'receita', 'transferencia']);
                $table->decimal('valor', 10, 2);
                $table->date('data_lancamento');
                $table->date('data_vencimento')->nullable();
                $table->date('data_pagamento')->nullable();
                $table->enum('repeticao', ['diaria', 'semanal', 'quinzenal', 'mensal', 'anual', 'unica']);
                $table->foreignId('categoria_id')->nullable()->constrained('financeiro_categorias')->nullOnDelete();
                $table->string('categoria_nome')->nullable();
                $table->foreignId('conta_id')->nullable()->constrained('financeiro_contas_bancarias')->nullOnDelete();
                $table->enum('situacao', ['pendente', 'pago', 'cancelado'])->default('pendente');
                $table->string('descricao')->nullable();
                $table->text('observacao')->nullable();
                $table->timestamps();
            });
        }

        Schema::create('financeiro_lacamentos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->decimal('valor', 10, 2);
            $table->date('data');
            $table->string('repeticao')->nullable();
            $table->string('categoria')->nullable();
            $table->foreignId('categoria_id')->nullable()->constrained('financeiro_categorias')->onDelete('set null');
            $table->string('conta');
            $table->foreignId('conta_id')->nullable()->constrained('financeiro_contas_bancarias')->onDelete('set null');
            $table->string('periodicidade')->nullable();
            $table->integer('parcelas')->nullable();
            $table->string('observacao')->nullable();
            $table->timestamps();
        });
    }
};
