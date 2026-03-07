<?php

use App\Models\AlertRule;
use App\Models\SensorParameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_rule_sensor_parameter', function (Blueprint $table) {
            $table->foreignIdFor(AlertRule::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SensorParameter::class)->constrained()->cascadeOnDelete();
            $table->primary(['alert_rule_id', 'sensor_parameter_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_rule_sensor_parameter');
    }
};
