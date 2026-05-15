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
        Schema::create('tramite_movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tramite_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('estado_anterior');
            $table->string('estado_nuevo');
            $table->string('departamento_origen')->nullable();
            $table->string('departamento_destino')->nullable();
            $table->text('comentarios')->nullable();
            $table->json('adjuntos')->nullable(); // JSON array con paths de archivos adjuntos
            $table->timestamp('fecha_movimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite_movimientos');
    }
};
