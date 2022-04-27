<?php

namespace App\Listeners;

use App\Events\LessonUsersUpdatingEvent;
use App\Exceptions\AlreadyCompleteException;
use App\Helpers\ValidateHelper;
use App\Models\LessonUsers;
use App\Rules\IsPassedRule;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class LessonUsersCheckIsPassedListener
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
     * @param LessonUsersUpdatingEvent $event
     * @throws AlreadyCompleteException
     * @throws ValidateException
     * @throws ObjectNotFoundException
     */
    public function handle(LessonUsersUpdatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $validate = new ValidateHelper($attributes, [
            "is_passed" => [new IsPassedRule()],
        ]);
        $validate->validate();

        if (LessonUsers::actionGetItem($attributes['id'])['is_passed']) {
            $exception = new AlreadyCompleteException();
            throw $exception;
        }
    }
}
