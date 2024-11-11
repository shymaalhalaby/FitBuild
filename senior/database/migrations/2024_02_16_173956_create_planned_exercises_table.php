<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('planned_exercises', function (Blueprint $table) {
            $table->id();
            $table->integer('RepeatCount')->nullable();
            $table->integer('Set')->nullable();
            $table->string('Duration')->nullable();
            $table->string('TrainingTips')->nullable();
            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->unsignedBigInteger('daily_exercise_id')->nullable();
            $table->timestamps();
            $table->foreign('exercise_id')->references('id')->on('exercises');
            $table->foreign('daily_exercise_id')->references('id')->on('daily_exercises');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planned_exercises');
    }
};
