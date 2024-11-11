<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\member;
use App\Models\Nutritionist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // or Hash::make('password')
            'gender' => $this->faker->randomElement(['male', 'female']),
            'Subscription_type' => $this->faker->randomElement(['daily','3days']),
            'phone_number' => $this->faker->numerify('##########'), // Generate a 10-digit phone number
            'Age' => $this->faker->numberBetween(18, 65),
            'illness' => $this->faker->text(100),
            'GOAL' => $this->faker->text(100),
            'Physical_case' => $this->faker->text(100),
            'Hieght' => $this->faker->randomFloat(2, 1.5, 2.0),
            'Wieght' => $this->faker->randomFloat(2, 50, 100),
            'target_Wieght' => $this->faker->randomFloat(2, 50, 100),
            'AT' => $this->faker->randomElement(['Home', 'Gym']),
            'coach_id' => null, // This will be set in the seeder
            'nutritionist_id' => null, // This will be set in the seeder
            'user_id' => null, // This will be set in the seeder
        ];
    }
}

