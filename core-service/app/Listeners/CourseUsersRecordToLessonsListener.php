<?php

namespace App\Listeners;

// неиспользуемые import
use App\Events\CourseUsersCreatedEvent;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Models\Courses;
use App\Models\Lessons;
use App\Models\LessonUsers;
use Egal\Model\Exceptions\ObjectNotFoundException;

class CourseUsersRecordToLessonsListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $course_id = $event->getModel()->getAttributes()['course_id'];
        $user_id = $event->getModel()->getAttributes()['user_id'];

        $lessons = Lessons::query()->where('course_id',$course_id)->get();
        foreach ($lessons as $lesson) {
            // нам точно стоит вызывать action?
            LessonUsers::actionCreate(["user_id" => $user_id, "lesson_id" => $lesson['id'], "is_passed" => false]);
        }
    }
}










