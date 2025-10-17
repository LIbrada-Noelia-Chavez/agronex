<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // insumo, maquinaria, herramienta, semilla, fertilizante
            $table->string('categoria')->nullable();
            $table->integer('cantidad');
            $table->string('unidad_medida'); // kg, litros, unidades, etc.
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->decimal('stock_minimo', 8, 2)->default(0);
            $table->decimal('stock_maximo', 8, 2)->nullable();
            $table->string('proveedor')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('ubicacion')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('disponible'); // disponible, agotado, bajo_stock
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
