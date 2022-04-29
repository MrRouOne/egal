<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Exceptions\CapacityException;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Models\Courses;
use Egal\Model\Exceptions\ObjectNotFoundException;

class CourseUsersCheckCapacityListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws CapacityException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $course_id = $event->getModel()->getAttributes()['course_id'];

        if (Courses::query()->find($course_id)['student_capacity'] === 0) {
            throw new CapacityException();
        }
    }
}










