<?php

namespace App\Listeners;

use App\Events\LessonUsersUpdatingEvent;
use App\Helpers\ValidateHelper;
use App\Models\Courses;
use App\Models\Lessons;
use App\Rules\EndDateRule;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class LessonUsersCheckFinishCourseListener
{
    /**
     * @param LessonUsersUpdatingEvent $event
     * @throws ValidateException
     * @throws ObjectNotFoundException
     */
    public function handle(LessonUsersUpdatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $course = Courses::query()->find(Lessons::query()->find($attributes['lesson_id'])['course_id'])->toArray();
        $validate = new ValidateHelper;
        $validate->validate($course, [
            "end_date" => [new EndDateRule],
        ]);
    }
}
