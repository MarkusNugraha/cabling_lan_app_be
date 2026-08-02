<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('extension_number')->unique();
            $table->string('ip_address')->unique();
            $table->string('mac_address')->unique();
            $table->string('manufacturer');
            $table->string('model');
            $table->foreignId('connected_pc_device_id')
                ->nullable()
                ->constrained('devices')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('note')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voips');
    }
};
