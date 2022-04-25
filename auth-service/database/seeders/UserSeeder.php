<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    public function run()
    {
        $userScheme = [
            'id' => Str::uuid(),
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'phone' => "+7(777)777-77-77",
            'first_name' => "user",
            'last_name' => "user",

        ];

        if (!User::query()->where('email', $userScheme['email'])->first()) {
             User::query()->create($userScheme);
        }
    }
}
