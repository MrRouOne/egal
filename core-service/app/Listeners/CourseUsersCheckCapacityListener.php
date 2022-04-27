<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Exceptions\CapacityException;
use App\Models\Courses;
use Egal\Model\Exceptions\ObjectNotFoundException;


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
     * @param CourseUsersCreatingEvent $event
     * @throws CapacityException
     * @throws ObjectNotFoundException
     */
    public function handle(CourseUsersCreatingEvent $event): void
    {
        $course_id = $event->data->getAttributes()['course_id'];

        if (Courses::actionGetItem($course_id)['student_capacity'] === 0) {
            throw new CapacityException();
        }
    }
}










