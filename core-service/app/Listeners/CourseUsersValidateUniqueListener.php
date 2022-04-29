<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Helpers\ValidateHelper;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class CourseUsersValidateUniqueListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $attributes = $event->getModel()->getAttributes();
        $course_id = $attributes['course_id'];

        $validate = new ValidateHelper;
        $validate->validate($attributes, [
            "user_id" => "required|uuid|unique:course_users,user_id,null,null,course_id,$course_id",
        ]);
    }
}
