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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->string('data_fim')->nullable();
            $table->time('hora')->nullable();
            $table->string('local')->nullable();
            $table->text('descricao')->nullable();
            $table->text('situacao')->nullable();
            $table->text('responsavel')->nullable();
            $table->text('categoria')->nullable();
            $table->text('links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
