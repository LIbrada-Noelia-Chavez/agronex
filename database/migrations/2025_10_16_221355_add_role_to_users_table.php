<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta los cambios en la base de datos.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añade el campo 'role' con valor por defecto 'capataz_cultivo'
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')
                    ->default('capataz_cultivo')
                    ->after('password');
            }
        });
    }

    /**
     * Revierte los cambios.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
