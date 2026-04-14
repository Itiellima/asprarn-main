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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('associado_id')->constrained('associados')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->date('data_pagamento');
            $table->date('mes_referencia')->nullable();
            $table->string('metodo_pagamento')->nullable();
            $table->string('tipo')->default('mensalidade');
            $table->string('status')->default('pago');
            $table->string('numero_documento')->nullable();
            $table->string('origem')->default('manual');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('observacao')->nullable();
            $table->index('associado_id');
            $table->index('mes_referencia');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
