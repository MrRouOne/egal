<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'phone' => "+8(888)888-88-88",
            'first_name' => "admin",
            'last_name' => "admin",

        ];

        if (!User::query()->where('email', $userScheme['email'])->first()) {
            User::query()->create($userScheme)->roles()->attach('admin');
        }
    }
}
