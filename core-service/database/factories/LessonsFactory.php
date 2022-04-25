<?php

namespace Database\Factories;

use App\Models\Courses;
use Illuminate\Database\Eloquent\Factories\Factory;


class LessonsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Courses::all()->random()->id,
            'theme' => $this->faker->word,
        ];
    }

}
