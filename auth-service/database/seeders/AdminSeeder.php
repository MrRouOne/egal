<?php

namespace Database\Seeders;

use App\Models\User;
use Egal\Core\Communication\Request;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userData = [
            'id' => Str::uuid(),
            'email' => 'admin@gmail.com',
            // будет хешироваться хеш
            'password' => Hash::make('admin'),
        ];

        // уменьшаем вложенность
        if (!User::query()->where('email', $userData['email'])->first()) {
            User::query()->create($userData)->roles()->attach('admin');

            $request = new Request(
                'core',
                'Users',
                'create',
                [
                    'attributes' => [
                        'id' => $userData['id'],
                        'phone' => "+8(888)888-88-88",
                        'first_name' => "admin",
                        'last_name' => "admin",
                    ]]
            );

            $request->call();
        }
    }
}
