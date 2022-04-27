<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    protected $model = User::class;

    /**
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'email' => $this->faker->email,
            'password' => Hash::make(Str::random(10)),
            'phone' => "+" . random_int(1, 8) . "(" . random_int(100, 999) . ")" . random_int(100, 999) . "-" . random_int(10, 99) . "-" . random_int(10, 99),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ];
    }

}
