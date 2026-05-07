<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),

            'user_id' => User::inRandomOrder()->first()->id,
            'job_type_id' => JobType::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,

            'vacancy' => rand(1,5),
            'location' => fake()->city(),
            'description' => fake()->text(),
            'experience' => rand(1,10),
            'company_name' => fake()->company(),
            //
        ];
    }
}