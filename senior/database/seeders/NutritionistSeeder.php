<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\member;
use App\Models\Nutritionist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NutritionistSeeder extends Seeder
{
    public function run(): void
    {
        $members = member::all();
        $Nutritionists = Nutritionist::all();
        $statuses = ['pending', 'Rejected', 'Accepted'];


        if ($members->isNotEmpty() && $Nutritionists->isNotEmpty()) {
            foreach ($members as $member) {
                DB::table('member_nutritionist')->insert([
                    'member_id' => $member->id,
                    'Nutritionist_id' => $Nutritionists->random()->id,
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}