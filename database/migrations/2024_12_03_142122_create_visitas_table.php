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
            $table->foreignId('visitante_id')->constrained('visitantes')->onDelete('restrict');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('restrict');
            $table->foreignId('razon_id')->constrained('razonvisitas')->onDelete('restrict');
            $table->string('otra_razon_visita')->nullable();
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('restrict');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->integer('total_visitantes')->default(1)->nullable();
            $table->text('pertenencias')->nullable();
            $table->timestamps();

            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');

            // Borrado lógico
            $table->softDeletes();

            // Índices para búsqueda
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
            $table->index(['visitante_id', 'fecha_inicio']);
            $table->index(['empleado_id', 'fecha_inicio']);
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
