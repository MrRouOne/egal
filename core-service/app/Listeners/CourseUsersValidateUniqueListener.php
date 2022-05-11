<?php

namespace App\Listeners;

use MrRouOne\Helpers\AbstractEvent;
use MrRouOne\Helpers\AbstractListener;
use MrRouOne\Helpers\ValidateHelper;
use Egal\Model\Exceptions\ValidateException;

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

        ValidateHelper::validate($attributes, [
            "user_id" => "required|uuid|unique:course_users,user_id,null,null,course_id,$course_id",
        ]);
    }
}
