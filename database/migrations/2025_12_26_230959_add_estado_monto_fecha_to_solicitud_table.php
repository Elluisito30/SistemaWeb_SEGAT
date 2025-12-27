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
        Schema::table('solicitud', function (Blueprint $table) {
            $table->enum('estado', ['registrada', 'en atención', 'atendida', 'rechazada'])
                  ->default('registrada')
                  ->after('documentoAdjunto');
            $table->decimal('monto', 8, 2)->nullable()->after('estado');
            $table->date('fechaProgramada')->nullable()->after('monto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud', function (Blueprint $table) {
            $table->dropColumn(['estado', 'monto', 'fechaProgramada']);
        });
    }
};
