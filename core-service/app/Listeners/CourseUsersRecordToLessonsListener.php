<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatedEvent;
use App\Models\Courses;
use App\Models\Lessons;
use App\Models\LessonUsers;
use Egal\Model\Exceptions\ObjectNotFoundException;

class CourseUsersRecordToLessonsListener
{
    /**
     * @param CourseUsersCreatedEvent $event
     * @throws ObjectNotFoundException
     */
    public function handle(CourseUsersCreatedEvent $event): void
    {
        $course_id = $event->data->getAttributes()['course_id'];
        $user_id = $event->data->getAttributes()['user_id'];

        $lessons = Lessons::query()->where('course_id',$course_id)->get();
        foreach ($lessons as $lesson) {
            LessonUsers::actionCreate(["user_id" => $user_id, "lesson_id" => $lesson['id'], "is_passed" => false]);
        }
    }
}










