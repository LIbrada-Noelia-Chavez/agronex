<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('weather_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('source');     // 'open-meteo'
            $table->string('type');       // temperature, humidity, rain, wind_speed, soil_temperature, precipitation_probability
            $table->float('value')->nullable();
            $table->json('payload')->nullable();  // JSON crudo de la API
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('weather_readings');
    }
};
