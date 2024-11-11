<?php

use App\Models\gym;
use App\Models\User;
use App\Models\coach;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender', ['male', 'female']);
            $table->integer('Age');
            $table->bigInteger('phone_number');
            $table->time('WorkHours');
            $table->string('training_price');
            $table->enum('work_type', ['Freelance', 'WithGym']);
            $table->boolean('status')->default(1);
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete;
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
};
