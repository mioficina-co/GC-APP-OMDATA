<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('numero_documento', 50);
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('compania', 100)->nullable();
            $table->string('placa_vehiculo', 20)->nullable();
            $table->string('nombre_contacto_emergencia', 100)->nullable();
            $table->string('numero_contacto_emergencia', 20)->nullable();
            $table->boolean('activo')->default(true);
            $table->foreignId('eps_id')->constrained('eps')->onDelete('restrict');
            $table->foreignId('arl_id')->constrained('arl')->onDelete('restrict');
            $table->foreignId('tipos_documento_id')->constrained('tipos_documento')->onDelete('cascade');
            $table->foreignId('pais_id')->constrained('paises')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitantes');
    }
};
