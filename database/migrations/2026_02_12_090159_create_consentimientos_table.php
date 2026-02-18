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
        Schema::create('consentimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitante_id')->constrained('visitantes')->onDelete('restrict');
            $table->foreignId('politica_id')->constrained('politica_privacidads')->onDelete('restrict');
            $table->boolean('acepta')->default(true);
            $table->timestamp('fecha_aceptacion')->useCurrent();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['visitante_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consentimientos');
    }
};
