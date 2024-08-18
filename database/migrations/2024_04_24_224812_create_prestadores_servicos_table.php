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
        Schema::create('prestadores_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('tipo', ['pessoa_fisica', 'pessoa_juridica']);
            $table->string('categoria', 100);
            $table->string('nome', 100);
            $table->string('sobrenome', 200)->nullable();
            $table->string('cpf', 100)->nullable();
            $table->string('rg', 100)->nullable();
            $table->date('nascimento')->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('site', 100)->nullable();
            $table->foreignId('endereco_id')->nullable()->constrained('enderecos')->cascadeOnUpdate()->nullOnDelete();
            $table->string('foto_id', 100)->nullable();
            $table->string('descricao', 255)->nullable();
            $table->foreignId('empresa_id')->nullable()->constrained('empresas_servicos')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestadores_servicos');
    }
};
