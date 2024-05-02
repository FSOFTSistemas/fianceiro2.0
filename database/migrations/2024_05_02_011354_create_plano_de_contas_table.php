<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plano_de_contas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->default('despesa'); //  despesa, receita
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        $path = public_path('db/plano_de_contas.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_de_contas');
    }
};
