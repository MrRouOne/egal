<?php

namespace Database\Factories;

use App\Models\Courses;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;


class LessonFactory extends Factory
{

    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'course_id' => Courses::all()->random()->id,
            'theme' => $this->faker->word,
        ];
    }

}
