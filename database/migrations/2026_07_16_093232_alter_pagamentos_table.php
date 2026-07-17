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
        //
        Schema::table('pagamentos', function (Blueprint $table) {

            $table->dropForeign(['associado_id']);

            $table->foreign('associado_id')->references('id')->on('associados')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('pagamentos', function (Blueprint $table) {

            $table->dropForeign(['associado_id']);

            $table->foreign('associado_id')->references('id')->on('associados')->restrictOnDelete();
        });
    }
};
