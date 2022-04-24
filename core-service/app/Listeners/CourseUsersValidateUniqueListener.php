<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Exceptions\CapacityException;
use App\Models\Courses;
use App\Models\CourseUsers;
use App\Rules\CorrectUserIdRule;
use Egal\Core\Exceptions\RequestException;
use Egal\Core\Listeners\GlobalEventListener;
use Egal\Core\Listeners\EventListener;
use Egal\Core\Session\Session;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class CourseUsersValidateUniqueListener
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
        $course_id = $attributes['course_id'];

        $validator = Validator::make($attributes, [
            "user_id" => "required|uuid|unique:course_users,user_id,null,null,course_id,$course_id",
        ]);

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }
    }
}
