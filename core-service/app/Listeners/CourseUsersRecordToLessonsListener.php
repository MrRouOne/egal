<?php

namespace App\Listeners;

use MrRouOne\Helpers\AbstractEvent;
use MrRouOne\Helpers\AbstractListener;
use App\Models\Lessons;
use App\Models\LessonUsers;

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
            LessonUsers::query()->create(["user_id" => $user_id, "lesson_id" => $lesson['id'], "is_passed" => false]);
        }
    }
}










