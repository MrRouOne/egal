<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Events\LessonUsersUpdatingEvent;
use App\Exceptions\CapacityException;
use App\Exceptions\ForbiddenFieldsException;
use App\Models\Courses;
use App\Models\CourseUsers;
use App\Models\Lessons;
use App\Models\LessonUsers;
use App\Rules\CorrectUserIdRule;
use App\Rules\ForbiddenFieldRule;
use Egal\Core\Exceptions\RequestException;
use Egal\Core\Listeners\GlobalEventListener;
use Egal\Core\Listeners\EventListener;
use Egal\Core\Session\Session;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class LessonUsersCheckFieldsListener
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
     * @param LessonUsersUpdatingEvent $event
     */
    public function handle(LessonUsersUpdatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();
        $lesson = LessonUsers::actionGetItem($attributes['id']);

        if ($attributes['user_id'] !== $lesson['user_id'] or $attributes['lesson_id'] !== $lesson['lesson_id']) {
            $exception = new ForbiddenFieldsException();
            throw $exception;
        }

    }
}
