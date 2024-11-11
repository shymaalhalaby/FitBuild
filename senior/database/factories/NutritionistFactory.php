<?php

namespace Database\Factories;

use App\Models\Nutritionist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nutritionist>
 */
class NutritionistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Nutritionist::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // or Hash::make('password')
            'gender' => $this->faker->randomElement(['male', 'female']),
            'Age' => $this->faker->numberBetween(25, 60),
            'phone_number' => $this->faker->numerify('##########'), // Generate a 10-digit phone number
            'WorkHours' => $this->faker->time(),
            'training_price' => $this->faker->randomFloat(2, 50, 200),
            'work_type' => $this->faker->randomElement(['Freelance', 'WithGym']),
            'status' => 1,
            'user_id' => null, // This will be set in the seeder
        ];
    }
}
