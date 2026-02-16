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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitante_id')->nullable()->constrained('visitantes')->onDelete('set null');
            $table->foreignId('visita_id')->nullable()->constrained('visitas')->onDelete('set null');
            $table->enum('tipo', ['foto', 'firma', 'documento_adjunto']);
            $table->string('ruta', 2048);
            $table->string('nombre_original');
            $table->string('mime_type', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
