<?php

namespace Database\Seeders;

use App\Models\User;
use Egal\Core\Communication\Request;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $userData = [
                'id' => Str::uuid(),
                'email' => $this->faker->email,
                'password' => Hash::make($this->faker->password),
            ];

            // уменьшаем вложенность
            if (!User::query()->where('email', $userData['email'])->first()) {
                User::query()->create($userData);

                $request = new Request(
                    'core',
                    'Users',
                    'create',
                    [
                        'attributes' => [
                            'id' => $userData['id'],
                            'phone' => $this->faker->phoneNumber,
                            'first_name' => $this->faker->firstName,
                            'last_name' => $this->faker->lastName,
                        ]]
                );

                $request->call();
            }
        }
    }
}
