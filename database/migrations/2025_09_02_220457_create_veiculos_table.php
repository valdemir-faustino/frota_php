<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->json('fotos')->nullable();
            $table->json('documentos')->nullable();
            $table->string('placa')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->string('cor')->nullable();
            $table->year('ano');
            $table->enum('status', ['ativo', 'manutencao', 'inativo'])->default('ativo');
            $table->foreignId('motorista_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
        $table->dropForeign(['motorista_id']);
        $table->dropColumn('motorista_id');
    });
    }
};