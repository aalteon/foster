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
        Schema::create('wheel_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wheel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('foster_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('start_date');

            $table->date('end_date');

            $table->string('status')
                ->default('upcoming');
            // upcoming
            // active
            // completed
            // cancelled

            $table->string('source')
                ->default('auto');
            // auto
            // replacement
            // regenerated
            // manual

            $table->timestamp('generated_at')
                ->nullable();

            $table->timestamp('regenerated_at')
                ->nullable();

            $table->timestamp('replaced_at')
                ->nullable();

            $table->text('replacement_reason')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamp('notification_at')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wheel_assignments');
    }
};
