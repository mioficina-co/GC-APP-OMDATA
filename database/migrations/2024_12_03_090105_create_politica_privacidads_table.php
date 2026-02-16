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
        Schema::create('politica_privacidads', function (Blueprint $table) {
            $table->id();
            $table->string('version', 50);
            $table->longText('contenido');
            $table->timestamp('fecha_publicacion')->useCurrent();
            $table->boolean('activa')->default(true);
            $table->timestamps();

            // Auditoría: Quién realiza las acciones
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');

            // Borrado lógico para conservar evidencia histórica (Ley 1581)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('politica_privacidads');
    }
};
