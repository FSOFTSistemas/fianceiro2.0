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
        Schema::create('fluxo_de_caixas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plano_contas_id')->nullable();
            $table->foreign('plano_contas_id')->references('id')->on('plano_de_contas');
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('data_transacao');
            $table->enum('tipo', ['entrada', 'saida']); // Campo para distinguir entre entrada e saída
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fluxo_caixas', function (Blueprint $table) {
            $table->dropForeign(['plano_contas_id']);
            $table->dropColumn('plano_contas_id');
        });
    }
};
