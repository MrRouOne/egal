<?php

namespace Database\Seeders;

use App\Models\User;
use Egal\Core\Communication\Request;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    public function run()
    {
        $userData = [
            'id' => Str::uuid(),
            'email' => 'user@gmail.com',
            'password' => 'user',
        ];

        if (User::query()->where('email', $userData['email'])->first()) {
            return 0;
        }

        $dispatch = User::getEventDispatcher();
        User::unsetEventDispatcher();
        User::query()->create($userData);
        User::setEventDispatcher($dispatch);

        $request = new Request(
            'core',
            'Users',
            'create',
            [
                'attributes' => [
                    'id' => $userData['id'],
                    'phone' => "+7(777)777-77-77",
                    'first_name' => "user",
                    'last_name' => "user",
                ]]
        );
        $request->call();
    }
}
