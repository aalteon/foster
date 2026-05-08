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
        Schema::create('wheel_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wheel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('foster_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('position')->nullable();

            $table->enum('type', [
                'primary',
                'backup',
            ])->default('primary');

            $table->date('joined_at')
                ->nullable();

            $table->date('left_at')
                ->nullable();

            $table->unique(['wheel_id', 'foster_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wheel_members');
    }
};
