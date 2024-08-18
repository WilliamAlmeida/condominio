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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('bloco_id')->nullable()->constrained('blocos')->cascadeOnUpdate()->nullOnDelete();
            $table->enum('tipo', ['casa', 'apartamento'])->nullable();
            $table->string('andar', 100)->nullable();
            $table->string('rua', 255)->nullable();
            $table->string('numero', 100)->nullable();
            $table->foreignId('proprietario_id')->nullable()->constrained('moradores')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imovel');
    }
};
