<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NutritionistRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run()
     {

         $statuses = ['pending', 'Reject', 'Accept'];


         $NutritionistIds = DB::table('nutritionists')
                       ->where('work_type', 'WithGym')
                       ->pluck('id')
                       ->toArray();


         $gymIds = range(1, 13);


         $NutritionistRequests = [];


         foreach ($NutritionistIds as $NutritionistId) {

             $gymId = $gymIds[array_rand($gymIds)];

             $NutritionistRequests[] = [
                 'Nutritionist_id' => $NutritionistId,
                 'gym_id' => $gymId,
                 'status' => $statuses[array_rand($statuses)],
                 'created_at' => now(),
                 'updated_at' => now(),
             ];
         }


         DB::table('nutritionist_requests')->insert($NutritionistRequests);
     }
 }






