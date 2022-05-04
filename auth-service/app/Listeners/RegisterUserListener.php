<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use Egal\Model\Exceptions\ValidateException;
use App\Helpers\ValidateHelper;
use Illuminate\Support\Str;
use Egal\Core\Communication\Request;

class RegisterUserListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);

        $attributes = $event->attributes;
        if (!$attributes['password']) {
            throw new EmptyPasswordException();
        }

        $validate = new ValidateHelper;
        $validate->validate($attributes, [
            "email" => "required|string|email|unique:users,email",
            "first_name" => 'required|string',
            "last_name" => 'required|string',
            "phone" => 'required',
        ]);

        $event->user->setAttribute("id", Str::uuid());
        $event->user->setAttribute('email', $attributes['email']);
        $event->user->setAttribute('password', $attributes['password']);

        $request = new Request(
            'core',
            'Users',
            'create',
            [
                "attributes" => [
                    "id" => $event->user['id'],
                    "first_name" => $attributes['first_name'],
                    "last_name" => $attributes['last_name'],
                    "phone" => $attributes['phone'],
                ]
            ],
        );
        $request->call();
    }
}
