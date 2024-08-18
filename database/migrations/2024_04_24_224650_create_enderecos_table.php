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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('cep', 10)->nullable();
            $table->string('rua', 100);
            $table->string('numero', 100)->nullable();
            $table->string('bairro', 100);
            $table->string('complemento', 100)->nullable();
            $table->foreignId('cidade_id')->nullable()->constrained('cidades')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('estado_id')->nullable()->constrained('estados')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
