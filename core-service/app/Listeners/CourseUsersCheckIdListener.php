<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Helpers\ValidateHelper;
use App\Rules\CorrectUserIdRule;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class CourseUsersCheckIdListener
{
    /**
     * @param CourseUsersCreatingEvent $event
     * @throws ValidateException
     */
    public function handle(CourseUsersCreatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $validate = new ValidateHelper;
        $validate->validate($attributes, [
            "user_id" => [new CorrectUserIdRule, 'required']]);
    }
}
