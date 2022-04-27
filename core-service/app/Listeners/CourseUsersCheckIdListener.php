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
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @param CourseUsersCreatingEvent $event
     * @throws ValidateException
     */
    public function handle(CourseUsersCreatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $validate = new ValidateHelper($attributes, [
            "user_id" => [new CorrectUserIdRule, 'required']]);
        $validate->validate();
    }
}
