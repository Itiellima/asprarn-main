<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "beneficios" guarda a lista de benefícios em JSON, mas era VARCHAR(255):
 * poucos benefícios com acento (cada um vira ç no JSON) já estouravam o limite.
 * Os registros existentes já são JSON válido (vêm do cast array do model).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planos', function (Blueprint $table) {
            $table->json('beneficios')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('planos', function (Blueprint $table) {
            $table->string('beneficios')->nullable()->change();
        });
    }
};
