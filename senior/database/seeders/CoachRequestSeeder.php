<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoachRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $statuses = ['pending', 'Reject', 'Accept'];


        $coachIds = DB::table('coaches')
                      ->where('work_type', 'WithGym')
                      ->pluck('id')
                      ->toArray();


        $gymIds = range(1, 13);


        $CoachRequests = [];


        foreach ($coachIds as $coachId) {

            $gymId = $gymIds[array_rand($gymIds)];

            $CoachRequests[] = [
                'coach_id' => $coachId,
                'gym_id' => $gymId,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

    
        DB::table('coach_requests')->insert($CoachRequests);
    }
}
