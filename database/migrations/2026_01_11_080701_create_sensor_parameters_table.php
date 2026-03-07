<?php

use App\Models\SensorDevice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(SensorDevice::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('platform_parameter_id')->default(0);
            $table->string('unit')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_parameters');
    }
};
