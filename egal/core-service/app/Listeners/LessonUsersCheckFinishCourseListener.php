<?php

namespace App\Listeners;

use MrRouOne\Helpers\AbstractEvent;
use MrRouOne\Helpers\AbstractListener;
use MrRouOne\Helpers\ValidateHelper;
use App\Models\Courses;
use App\Models\Lessons;
use App\Rules\EndDateRule;
use Egal\Model\Exceptions\ValidateException;

class LessonUsersCheckFinishCourseListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $attributes = $event->getModel()->getAttributes();

        $course = Courses::query()->findOrFail(Lessons::query()->find($attributes['lesson_id'])['course_id'])->toArray();
        ValidateHelper::validate($course, [
            "end_date" => [new EndDateRule],
        ]);
    }
}
