<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('solicitud', function (Blueprint $table) {
            $table->enum('estado', ['registrada', 'en_atencion', 'atendida', 'rechazada'])
                  ->default('registrada')
                  ->after('fechaTentativaEjecucion');
        });
    }

    public function down()
    {
        Schema::table('solicitud', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};