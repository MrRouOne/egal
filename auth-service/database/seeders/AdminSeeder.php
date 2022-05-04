<?php

namespace Database\Seeders;

use App\Models\User;
use Egal\Core\Communication\Request;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userData = [
            'id' => Str::uuid(),
            'email' => 'admin@gmail.com',
            'password' => 'admin',
        ];

        if (User::query()->where('email', $userData['email'])->first()) {
            return 0;
        }

        $dispatch = User::getEventDispatcher();
        User::unsetEventDispatcher();
        User::query()->create($userData)->roles()->attach('admin');
        User::setEventDispatcher($dispatch);

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
