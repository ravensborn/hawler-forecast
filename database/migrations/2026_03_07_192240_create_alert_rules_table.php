<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('operator');
            $table->decimal('threshold', 10, 4);
            $table->unsignedInteger('cooldown_hours')->default(6);
            $table->boolean('should_notify')->default(false);
            $table->string('alert_icon');
            $table->json('alert_title');
            $table->json('alert_description');
            $table->string('alert_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_rules');
    }
};
