<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use App\Rules\PhoneRule;
use Egal\Core\Exceptions\RequestException;
use Egal\Core\Listeners\GlobalEventListener;
use Egal\Core\Listeners\EventListener;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class CreateUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param CreateUserEvent $event
     */
    public function handle(CreateUserEvent $event): void
    {
        $attributes = $event->user->getAttributes();

        $validator = Validator::make($attributes, [
            "id" =>  'required',
            "first_name" =>  'required|string',
            "last_name" =>  'required|string',
            "phone" => [new PhoneRule, 'required'],
        ]);

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }

        $request = new \Egal\Core\Communication\Request(
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
