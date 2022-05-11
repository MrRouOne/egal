<?php

namespace Database\Seeders;

use App\Models\Lessons;
use Illuminate\Database\Seeder;

class LessonsUsers extends Seeder
{
    public function run()
    {
        Lessons::factory()->count(25)->create();
    }
}
