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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('tipo'); // "Oficio", "Acta", "TUPA", etc.
            $table->text('descripcion')->nullable(); // nullable por si no quieren poner descripción
            $table->string('archivo_path'); // Ruta del PDF
            $table->string('estado')->default('Publicado');
            
            // CORRECCIÓN: Faltaba el punto y coma al final de esta línea
            $table->timestamp('fecha_publicacion')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};