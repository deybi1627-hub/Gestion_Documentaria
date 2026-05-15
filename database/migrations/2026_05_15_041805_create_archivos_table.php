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
            $table->foreignId('documento_id')->constrained()->onDelete('cascade');
            $table->string('ubicacion_fisica')->nullable(); // Ej: "Estante A, Caja 5"
            $table->string('codigo_archivo')->unique();
            $table->integer('anio');
            $table->string('departamento');
            $table->string('estado')->default('archivado'); // archivado, prestado, destruido
            $table->timestamp('fecha_archivacion');
            $table->timestamp('fecha_destruccion')->nullable(); // Según política de retención
            $table->text('notas')->nullable();
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
