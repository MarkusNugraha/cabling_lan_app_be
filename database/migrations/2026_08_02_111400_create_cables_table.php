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
        Schema::create('cables', function (Blueprint $table) {
            $table->id();
            $table->string('cable_code')->unique();
            $table->foreignId('from_switch_port_id')
                ->nullable()
                ->constrained('switch_ports')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('to_device_id')
                ->nullable()
                ->constrained('devices')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->decimal('length_m')->nullable();
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
        Schema::dropIfExists('cables');
    }
};
