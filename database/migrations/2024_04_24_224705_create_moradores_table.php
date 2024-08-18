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
        Schema::create('moradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nome', 100);
            $table->string('sobrenome', 200);
            $table->string('rg', 100)->nullable();
            $table->string('cpf', 15)->nullable();
            $table->date('nascimento')->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('email', 255)->nullable();
            $table->integer('foto_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moradores');
    }
};
