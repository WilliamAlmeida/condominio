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
        Schema::create('empresas_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('categoria', 100);
            $table->string('cnpj', 18)->nullable();
            $table->string('razao_social', 255);
            $table->string('nome_fantasia', 255);
            $table->string('inscricao_estadual', 100)->nullable();
            $table->string('inscricao_municipal', 100)->nullable();
            $table->string('telefone_1', 15);
            $table->string('telefone_2', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('site', 100)->nullable();
            $table->foreignId('endereco_id')->nullable()->constrained('enderecos')->cascadeOnUpdate()->nullOnDelete();
            $table->string('foto_id', 100)->nullable();
            $table->string('descricao', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condominios_servicos');
    }
};
