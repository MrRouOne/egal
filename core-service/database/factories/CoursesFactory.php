<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CoursesFactory extends Factory
{
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('now', '+14 days');

        return [
            'title' => $this->faker->word,
            'student_capacity' => random_int(10,35),
            'start_date' => $date,
            'end_date' => $this->faker->dateTimeBetween($date, '+14 days'),
            'has_certificate' => random_int(0,1),
        ];
    }

}
