<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('crop_type')->nullable();
            $table->string('field_location')->nullable();
            $table->date('planted_at')->nullable();
            $table->integer('moisture_threshold')->default(30);
            $table->string('status')->default('healthy');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('crops');
    }
};
