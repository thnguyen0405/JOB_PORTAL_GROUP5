<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Contract',
            'Full Time',
            'Internship',
            'Part Time'
        ];

        foreach ($types as $type) {
            JobType::firstOrCreate(
                ['name' => $type],
                ['status' => 1]
            );
        }
    }
}
