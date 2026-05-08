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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->string('name');

            $table->string('species')->nullable();
            $table->string('breed')->nullable();

            $table->string('color')->nullable();

            $table->enum('gender', ['male', 'female'])->nullable();

            $table->date('dob')->nullable();

            $table->decimal('weight', 5, 2)->nullable();

            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
