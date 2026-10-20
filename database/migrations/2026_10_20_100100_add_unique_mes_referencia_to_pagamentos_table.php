<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Um associado só pode ter um pagamento de cada tipo por mês de referência.
 * Evita mensalidades duplicadas ao reimportar o CSV ou por clique duplo.
 *
 * Se já existirem duplicados (dados antigos), esta migration falha:
 * resete as tabelas pagamentos e financeiro_lancamentos antes de rodá-la.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->unique(['associado_id', 'tipo', 'mes_referencia'], 'pagamentos_associado_tipo_mes_unique');
        });
    }

    public function down(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropUnique('pagamentos_associado_tipo_mes_unique');
        });
    }
};
