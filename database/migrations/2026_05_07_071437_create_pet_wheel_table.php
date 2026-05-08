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
        Schema::create('pet_wheel', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wheel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('pet_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['wheel_id', 'pet_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_wheel');
    }
};
