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
        Schema::create('wheels', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->integer('duration_days');

            $table->date('rotation_start_date');

            $table->integer('generate_days_ahead')
                ->default(30);

            $table->boolean('is_active')
                ->default(true);

            $table->boolean('notification')
                ->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wheels');
    }
};
