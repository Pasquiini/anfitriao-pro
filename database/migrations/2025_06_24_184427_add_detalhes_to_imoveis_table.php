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
        Schema::table('imoveis', function (Blueprint $table) {
            $table->integer('quartos')->unsigned()->nullable()->after('descricao');
            $table->integer('banheiros')->unsigned()->nullable()->after('quartos');
            $table->integer('acomoda')->unsigned()->nullable()->after('banheiros');
            $table->json('comodidades')->nullable()->after('acomoda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imoveis', function (Blueprint $table) {
            $table->dropColumn(['quartos', 'banheiros', 'acomoda', 'comodidades']);
        });
    }
};
