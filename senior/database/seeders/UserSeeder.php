<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Define gym-related data
        $names = [
            'Alshabab Gym', 'Fitness Gym', 'ONAD Gym', 'I Gym fitness factory',
            'Any Time Gym', 'Fitness 1440 Damascus', 'X academy Health & Fitness',
            'Fusion Gym', 'AL-cham sport center', 'First Class Fitness',
            'Sportcentrum Gym', 'Gold Gym', 'Fitness House'
        ];

        $emails = [
            'gym1@gmail.com', 'gym2@gmail.com', 'gym3@gmail.com', 'gym4@gmail.com',
            'gym5@gmail.com', 'gym6@gmail.com', 'gym7@gmail.com', 'gym8@gmail.com',
            'gym9@gmail.com', 'gym10@gmail.com', 'gym11@gmail.com', 'gym12@gmail.com',
            'gym13@gmail.com'
        ];

        $passwords = ['00000000'];
        $addresses = ['shalan', 'hamra', 'maysat', 'mazzeh', 'baramkeh', 'telyani'];
        $phone_number = '09876543';
        $land_number = '011654783';

        $descriptions = [
            "Fitness Enthusiast | Personal Trainer | Health & Wellness",
            "Transforming Lives Through Fitness | Certified Trainer",
            "Building Strength, Inside and Out",
            "Workout Warrior | Fitness Goals",
            "Pushing Limits Daily | Fitness Trainer | Health Advocate",
            "Strong Body, Strong Mind | Fitness Inspiration",
            "Your Fitness Journey Starts Here",
            "Sculpting Bodies, Shaping Lives | Fitness Expert",
            "Dedication & Determination | Personal Fitness Guide",
            "Empowering Fitness | Personal Training | Wellness Tips"
        ];

        $workhours_women = [
            "6:00 AM - 9:00 PM", "7:00 AM - 10:00 PM", "5:30 AM - 8:30 PM",
            "6:30 AM - 9:30 PM", "6:00 AM - 8:00 PM"
        ];

        $workhours_men = [
            "5:00 AM - 10:00 PM", "6:00 AM - 11:00 PM", "5:30 AM - 9:30 PM",
            "6:00 AM - 10:00 PM", "5:00 AM - 9:00 PM"
        ];

        $subscriptionprice_daily = ["120,000 SYP", "130,000 SYP", "150,000 SYP", "200,000 SYP"];
        $subscriptionprice_3days = ["100,000 SYP", "80,000 SYP", "120,000 SYP", "90,000 SYP"];



        for ($i = 0; $i < 13; $i++) {
            $gymUserId = DB::table('users')->insertGetId([
                'name' => $names[$i],
                'role' => 'gym',
                'email' => $emails[$i],
                'password' => Hash::make($passwords[array_rand($passwords)]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);



            DB::table('gyms')->insert([
                'user_id' => $gymUserId,
                'name' => $names[$i],
                'email' => $emails[$i],
                'password' => Hash::make($passwords[array_rand($passwords)]),
                'address' => $addresses[array_rand($addresses)],
                'logo' => null,
                'phone_number' => $phone_number,
                'land_number' => $land_number,
                'description' => $descriptions[array_rand($descriptions)],
                'workhours_women' => $workhours_women[array_rand($workhours_women)],
                'workhours_men' => $workhours_men[array_rand($workhours_men)],
                'subscriptionprice_daily' => $subscriptionprice_daily[array_rand($subscriptionprice_daily)],
                'subscriptionprice_3days' => $subscriptionprice_3days[array_rand($subscriptionprice_3days)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }



    }
}
