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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->string('numero_expediente')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('procedimiento_tupa_id')->constrained()->onDelete('cascade');
            $table->string('estado')->default('Recibido'); // Recibido, En Revisión, Aprobado, Rechazado, Finalizado
            $table->text('descripcion');
            $table->json('requisitos_completados')->nullable(); // JSON con checklist de requisitos
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_limite')->nullable();
            $table->timestamp('fecha_finalizacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
