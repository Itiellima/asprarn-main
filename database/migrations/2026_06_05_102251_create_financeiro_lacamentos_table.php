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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro_lacamentos');
    }
};
