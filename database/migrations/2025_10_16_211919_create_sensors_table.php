<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // temperatura, humedad, ph, etc.
            $table->string('ubicacion');
            $table->decimal('valor', 8, 2);
            $table->string('unidad');
            $table->string('estado')->default('activo');
            $table->timestamp('ultima_lectura')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};