<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{

    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'student_capacity' => random_int(10,35),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'has_certificate' => random_int(0,1),
        ];
    }

}
