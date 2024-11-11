<?php

use App\Models\Lunch;
use App\Models\Dinner;
use App\Models\BreakFast;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->string('BreakFast1');
            $table->string('BreakFast2');
            $table->string('BreakFast3');
            $table->string('BreakFast1_amount');
            $table->string('BreakFast2_amount');
            $table->string('BreakFast3_amount');
            $table->string('snack1');
            $table->string('Lunch1');
            $table->string('Lunch2');
            $table->string('Lunch1_amount');
            $table->string('Lunch2_amount')->nullable();
            $table->string('snack2');
            $table->string('Dinner1');
            $table->string('Dinner2')->nullable();
            $table->string('Dinner1_amount');
            $table->string('Dinner2_amount');
            $table->string('totalcalories')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};
