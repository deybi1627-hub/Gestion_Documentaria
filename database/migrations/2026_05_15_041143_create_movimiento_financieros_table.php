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
        Schema::create('movimiento_financieros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tramite_id')->nullable()->constrained()->onDelete('set null');
            $table->string('tipo')->default('ingreso'); // ingreso, egreso
            $table->string('categoria'); // Derechos de trámite, Gastos operativos, etc.
            $table->decimal('monto', 10, 2);
            $table->string('descripcion');
            $table->string('comprobante_path')->nullable();
            $table->string('estado')->default('pendiente'); // pendiente, pagado, cancelado
            $table->timestamp('fecha_transaccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_financieros');
    }
};
