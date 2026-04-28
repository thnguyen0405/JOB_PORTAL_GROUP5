<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Job;

class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'job_id'  => Job::inRandomOrder()->first()->id,
            'employer_id' => User::inRandomOrder()->first()->id,

            'applied_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}