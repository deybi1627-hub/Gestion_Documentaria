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
        Schema::table('documentos', function (Blueprint $table) {
            $table->foreignId('tramite_id')->nullable()->constrained()->onDelete('set null');
            $table->string('categoria')->default('general'); // oficial, interno, publico
            $table->string('departamento')->nullable();
            $table->boolean('confidencial')->default(false);
            $table->string('version')->default('1.0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropForeign(['tramite_id']);
            $table->dropColumn(['tramite_id', 'categoria', 'departamento', 'confidencial', 'version']);
        });
    }
};
