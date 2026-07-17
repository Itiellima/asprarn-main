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
        Schema::table('financeiro_lancamentos', function (Blueprint $table) {
            //
            $table->string('origem')->nullable()->default('Manual')->after('observacao');
            $table->unsignedBigInteger('origem_id')->nullable()->after('origem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financeiro_lancamentos', function (Blueprint $table) {
            //
            $table->dropColumn('origem_id');
            $table->dropColumn('origem');
        });
    }
};
