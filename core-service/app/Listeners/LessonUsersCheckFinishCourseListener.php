<?php

namespace App\Listeners;

use App\Events\LessonUsersUpdatingEvent;
use App\Helpers\ValidateHelper;
use App\Models\Lessons;
use App\Rules\EndDateRule;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class LessonUsersCheckFinishCourseListener
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
     * @param LessonUsersUpdatingEvent $event
     * @throws ValidateException
     * @throws ObjectNotFoundException
     */
    public function handle(LessonUsersUpdatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $course =  Lessons::actionGetItem($attributes['lesson_id'],["course"])['course'];

        $validate = new ValidateHelper($course, [
            "end_date" => [new EndDateRule],
        ]);
        $validate->validate();
    }
}
