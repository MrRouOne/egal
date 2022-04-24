<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Models\Courses;
use App\Models\CourseUsers;
use App\Rules\CorrectUserIdRule;
use Egal\Core\Exceptions\RequestException;
use Egal\Core\Listeners\GlobalEventListener;
use Egal\Core\Listeners\EventListener;
use Egal\Core\Session\Session;
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
     * Handle the event.
     *
     * @param CourseUsersCreatingEvent $event
     */
    public function handle(CourseUsersCreatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $validator = Validator::make($attributes, [
            "user_id" => [new CorrectUserIdRule, 'required'],
        ]);

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }
    }
}
