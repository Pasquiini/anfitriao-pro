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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained()->onDelete('cascade')->on('imoveis'); // Link com o imóvel
            $table->date('data_inicio'); // Data de check-in
            $table->date('data_fim'); // Data de check-out
            $table->string('nome_hospede'); // Nome do hóspede principal
            $table->string('contato_hospede'); // Telefone ou e-mail do hóspede
            $table->string('status')->default('confirmada');
            $table->timestamps();
            $table->softDeletes(); // Permite soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
