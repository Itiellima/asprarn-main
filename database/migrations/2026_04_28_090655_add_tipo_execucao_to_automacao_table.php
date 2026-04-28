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
        Schema::table('automacao', function (Blueprint $table) {
            $table->string('tipo_execucao')->nullable()->after('ultima_execucao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('automacao', function (Blueprint $table) {
            $table->dropColumn('tipo_execucao');
        });
    }
};
