<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropsTable extends Migration
{
    public function up()
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('crop_type')->nullable();
            $table->string('field_location')->nullable();
            $table->timestamp('planted_at')->nullable();
            $table->integer('moisture_threshold')->default(30); // porcentaje
            $table->decimal('temp_min', 5,2)->nullable();
            $table->decimal('temp_max', 5,2)->nullable();
            $table->string('status')->default('healthy');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crops');
    }
}
