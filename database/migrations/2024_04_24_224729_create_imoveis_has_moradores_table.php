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
        Schema::create('imoveis_has_moradores', function (Blueprint $table) {
            $table->foreignId('imovel_id')->nullable()->constrained('imoveis')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('morador_id')->nullable()->constrained('moradores')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis_has_moradores');
    }
};
