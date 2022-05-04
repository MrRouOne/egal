<?php

namespace App\Listeners;

use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Models\Courses;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\UpdateException;

class CourseUsersUpdateCapacityListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws ObjectNotFoundException
     * @throws UpdateException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $course_id = $event->getModel()->getAttributes()['course_id'];
        $current_capacity = Courses::query()->findOrFail($course_id)['student_capacity'];
        Courses::actionUpdate($course_id,["student_capacity" => $current_capacity-1]);
    }
}
