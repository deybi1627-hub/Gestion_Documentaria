<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campo de auditoría: quién aprobó/rechazó el movimiento financiero.
     */
    public function up(): void
    {
        Schema::table('movimiento_financieros', function (Blueprint $table) {
            $table->foreignId('aprobado_por')
                  ->nullable()
                  ->after('estado')
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('fecha_aprobacion')->nullable()->after('aprobado_por');

            $table->string('notas_internas', 500)->nullable()->after('fecha_aprobacion')
                  ->comment('Notas del funcionario al aprobar o rechazar el pago');
        });
    }

    public function down(): void
    {
        Schema::table('movimiento_financieros', function (Blueprint $table) {
            $table->dropForeign(['aprobado_por']);
            $table->dropColumn(['aprobado_por', 'fecha_aprobacion', 'notas_internas']);
        });
    }
};
