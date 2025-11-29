<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Delete old data first (optional)
        University::truncate();

        // Generate 500 fake universities
        University::factory()->count(500)->create();
    }
}
