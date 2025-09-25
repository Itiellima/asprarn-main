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
        Schema::create('associados', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('rg')->nullable();
            $table->string('org_expedidor')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('nome_mae')->nullable();
            $table->date('dt_nasc')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('grau_instrucao')->nullable();
            $table->string('nome_guerra')->nullable();
            $table->string('graduacao')->nullable();
            $table->string('nmr_praca')->nullable();
            $table->string('matricula')->nullable();
            $table->string('opm')->nullable();
            $table->string('dependentes')->nullable();
            $table->string('obs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associados');
    }
};
