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

class CourseUsersCheckCapacityListener
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
        $course_id = $event->data->getAttributes()['course_id'];

        if (Courses::actionGetItem($course_id)['student_capacity'] === 0) {
            $exception = new CapacityException();
            throw $exception;
        }
    }
}










