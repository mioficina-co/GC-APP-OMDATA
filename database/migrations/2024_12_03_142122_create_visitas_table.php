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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitante_id')->constrained('visitantes')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->foreignId('razon_id')->constrained('razonvisitas')->onDelete('cascade');
            $table->string('otra_razon_visita')->nullable();
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->integer('total_visitantes')->default(1)->nullable();
            $table->string('foto')->nullable();
            $table->text('firma_base64')->nullable();
            $table->boolean('acepta_politica')->default(false);
            $table->text('pertenencias')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
