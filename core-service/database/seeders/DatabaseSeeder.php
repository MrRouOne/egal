<?php

namespace Database\Seeders;

use App\Models\Courses;
use App\Models\Lessons;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CoursesSeeder::class);
        $this->call(LessonsUsers::class);
    }

}
