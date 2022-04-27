<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Helpers\ValidateHelper;
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
     * @param CourseUsersCreatingEvent $event
     * @throws ValidateException
     */
    public function handle(CourseUsersCreatingEvent $event): void
    {

        $attributes = $event->data->getAttributes();
        $course_id = $attributes['course_id'];

        $validate = new ValidateHelper($attributes, [
            "user_id" => "required|uuid|unique:course_users,user_id,null,null,course_id,$course_id",
        ]);
        $validate->validate();
    }
}
