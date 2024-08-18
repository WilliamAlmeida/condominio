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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nome', 100);
            $table->string('raca', 100)->nullable();
            $table->string('cor', 100)->nullable();
            $table->enum('porte', ['pequeno', 'medio', 'grande']);
            $table->date('nascimento')->nullable();
            $table->integer('foto_id')->nullable();
            $table->foreignId('proprietario_id')->nullable()->constrained('moradores')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
