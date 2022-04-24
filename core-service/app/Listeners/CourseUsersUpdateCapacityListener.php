<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatedEvent;
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

class CourseUsersUpdateCapacityListener
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
     * @param CourseUsersCreatedEvent $event
     */
    public function handle(CourseUsersCreatedEvent $event): void
    {
        $course_id = $event->data->getAttributes()['course_id'];
        $current_capacity = Courses::actionGetItem($course_id)['student_capacity'];
        Courses::actionUpdate($course_id,["student_capacity" => $current_capacity-1]);
    }
}
