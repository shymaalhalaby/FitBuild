<?php

use App\Models\gym;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gyms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('land_number')->nullable();
            $table->text('description')->nullable();
            $table->string('workhours_women')->nullable();
            $table->string('workhours_men')->nullable();
            $table->string('subscriptionprice_daily')->nullable();
            $table->string('subscriptionprice_3days')->nullable();
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gyms');
    }
};
