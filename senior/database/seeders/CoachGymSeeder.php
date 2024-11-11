<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\Coach;
use App\Models\CoachGym;
use Illuminate\Database\Seeder;

class CoachGymSeeder extends Seeder
{
    public function run()
    {
        // Define the number of records you want to create
        $numberOfRecords = 20;

        // Loop to create multiple records
        for ($i = 0; $i < $numberOfRecords; $i++) {
            // Replace these with actual Coach and Gym IDs
            $coachId = Coach::inRandomOrder()->first()->id;
            $gymId = Gym::inRandomOrder()->first()->id;

            // Create a new CoachGym record

          
        }
    }
}
