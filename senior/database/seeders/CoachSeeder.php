<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Coach;
use Illuminate\Database\Seeder;

class CoachSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'coach')->get();

        foreach ($users as $user) {
            Coach::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'gender' => 'male', // Or fetch from user data if available
                'Age' => 35,       // Or fetch from user data if available
                'phone_number' => 1234567892, // Or fetch from user data if available
                'WorkHours' => '08:00:00',
                'training_price' => '150',
                'work_type' => 'Freelance',
                'status' => 1,
            ]);
        }
    }
}
