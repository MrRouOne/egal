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
            // из за мутатора будет хешировать хеш
            'password' => Hash::make(Str::random(10)),
            // Удаляем неиспользуемые фрагменты
//            'phone' =>  $this->faker->phoneNumber,
//            'first_name' => $this->faker->firstName,
//            'last_name' => $this->faker->lastName,
        ];
    }

}
