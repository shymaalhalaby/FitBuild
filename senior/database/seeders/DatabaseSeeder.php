<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Coach;
use App\Models\Member;
use App\Models\Nutritionist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
     
        User::factory(30)->create(['role' => 'member'])->each(function ($user) {
            Member::factory()->create([
                'id'=>$user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_id' => $user->id,
            ]);
        });


        User::factory(30)->create(['role' => 'coach'])->each(function ($user) {
            Coach::factory()->create([
                'id'=>$user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_id' => $user->id,
            ]);
        });

        User::factory(30)->create(['role' => 'nutritionist'])->each(function ($user) {
            Nutritionist::factory()->create([
                'id'=>$user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_id' => $user->id,
            ]);
        });
    }
}
