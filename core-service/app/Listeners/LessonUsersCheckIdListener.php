<?php

namespace App\Listeners;

use App\Events\LessonUsersUpdatingEvent;
use App\Helpers\ValidateHelper;
use App\Rules\CorrectUserIdRule;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class LessonUsersCheckIdListener
{
    /**
     * @param LessonUsersUpdatingEvent $event
     * @throws ValidateException
     */
    public function handle(LessonUsersUpdatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $validate = new ValidateHelper;
        $validate->validate($attributes, [
            "user_id" => [new CorrectUserIdRule, 'required'],
        ]);
    }
}
