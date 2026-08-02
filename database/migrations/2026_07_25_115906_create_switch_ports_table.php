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
        Schema::create('switch_ports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')  // Device ID can't edittable once created
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->integer('port_number'); // Port number can't edittable once created
            $table->string('speed')->nullable();
            $table->foreignId('vlan_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('note')->nullable();
            $table->boolean('is_active');
            $table->timestamps();

            $table->unique(['device_id', 'port_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('switch_ports');
    }
};
