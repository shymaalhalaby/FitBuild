<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
      
        $statuses = ['pending', 'Reject', 'Accept'];


        $memberIds = DB::table('members')
                       ->where('AT', 'Gym')
                       ->pluck('id')
                       ->toArray();

        $gymIds = range(1, 13);


        $memberRequests = [];


        foreach ($memberIds as $memberId) {

            $gymId = $gymIds[array_rand($gymIds)];


            $memberRequests[] = [
                'member_id' => $memberId,
                'gym_id' => $gymId,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }


        DB::table('member_requests')->insert($memberRequests);
    }
}
