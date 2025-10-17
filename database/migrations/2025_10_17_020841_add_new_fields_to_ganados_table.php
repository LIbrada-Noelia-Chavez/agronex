<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ganados', function (Blueprint $table) {
            $table->enum('sexo', ['hembra', 'macho'])->nullable()->after('peso');
            $table->date('fecha_ingreso')->nullable()->after('estado');
            $table->string('lote', 50)->nullable()->after('fecha_ingreso');
            $table->text('observaciones')->nullable()->after('lote');
        });
    }

    public function down(): void
    {
        Schema::table('ganados', function (Blueprint $table) {
            $table->dropColumn(['sexo', 'fecha_ingreso', 'lote', 'observaciones']);
        });
    }
};