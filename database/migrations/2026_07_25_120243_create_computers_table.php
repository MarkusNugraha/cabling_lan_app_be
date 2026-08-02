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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('hostname')->unique();
            $table->string('cpu');
            $table->integer('ram_gb');
            $table->integer('storage_gb');
            $table->string('storage_type');
            $table->string('operating_system');
            $table->string('ip_address')->unique();
            $table->string('mac_address')->unique();
            $table->string('manufacturer');
            $table->string('model');
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
        Schema::dropIfExists('computers');
    }
};
