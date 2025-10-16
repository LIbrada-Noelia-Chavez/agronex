<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorReadingsTable extends Migration
{
    public function up()
    {
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->string('sensor_type');
            $table->decimal('value', 8, 3)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('sensor_readings');
    }
}
