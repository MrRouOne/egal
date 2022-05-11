<?php

namespace Database\Seeders;

use App\Models\Courses;

use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run()
    {
        Courses::factory()->count(5)->create();
    }
}
