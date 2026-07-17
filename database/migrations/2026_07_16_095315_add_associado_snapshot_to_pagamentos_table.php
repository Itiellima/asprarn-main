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
        Schema::table('pagamentos', function (Blueprint $table) {
            //
            $table->string('associado_nome')->nullable()->after('associado_id');
            $table->string('associado_cpf', 14)->nullable()->after('associado_nome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            //
            $table->dropColumn('associado_nome');
            $table->dropColumn('associado_cpf');
        });
    }
};
