<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatedEvent;
use App\Models\Courses;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\UpdateException;

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
     * @param CourseUsersCreatedEvent $event
     * @throws ObjectNotFoundException
     * @throws UpdateException
     */
    public function handle(CourseUsersCreatedEvent $event): void
    {
        $course_id = $event->data->getAttributes()['course_id'];
        $current_capacity = Courses::actionGetItem($course_id)['student_capacity'];
        Courses::actionUpdate($course_id,["student_capacity" => $current_capacity-1]);
    }
}
