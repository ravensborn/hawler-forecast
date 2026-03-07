<?php

use App\Models\SensorDeviceGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_devices', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->foreignIdFor(SensorDeviceGroup::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('platform_device_id')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_devices');
    }
};
