<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use App\Exceptions\PasswordHashException;
use App\Rules\PhoneRule;
use Egal\Model\Exceptions\ValidateException;
use App\Helpers\ValidateHelper;
use Illuminate\Support\Str;
use Egal\Core\Communication\Request;

class CreateUserListener
{
    /**
     * Handle the event.
     *
     * @param CreateUserEvent $event
     * @throws ValidateException
     */
    public function handle(CreateUserEvent $event): void
    {
        $event->user->setAttribute("id", Str::uuid());
        $attributes = $event->user->getAttributes();

        $validate = new ValidateHelper;
        $validate->validate($attributes, [

            "id" => 'required',
            "first_name" => 'required|string',
            "last_name" => 'required|string',
            "phone" => [new PhoneRule, 'required'],
        ]);

        $request = new Request(
            'core',
            'Users',
            'create',
            [
                "attributes" => [
                    "id" => $attributes['id'],
                    "first_name" => $attributes['first_name'],
                    "last_name" => $attributes['last_name'],
                    "phone" => $attributes['phone'],
                ]
            ],
        );
        $request->call();

        $event->user->offsetUnset('first_name');
        $event->user->offsetUnset('last_name');
        $event->user->offsetUnset('phone');

    }
}
