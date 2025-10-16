<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('crops', function (Blueprint $table) {
            $table->string('presentation')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('coverage_value', 10, 2)->nullable();
            $table->string('coverage_unit')->nullable();
        });
    }
    public function down(): void {
        Schema::table('crops', function (Blueprint $table) {
            $table->dropColumn(['presentation','price','coverage_value','coverage_unit']);
        });
    }
};