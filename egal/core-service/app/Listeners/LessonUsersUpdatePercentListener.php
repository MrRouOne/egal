<?php

namespace App\Listeners;

use MrRouOne\Helpers\AbstractEvent;
use MrRouOne\Helpers\AbstractListener;
use App\Models\Courses;
use App\Models\CourseUsers;
use App\Models\Lessons;
use App\Models\LessonUsers;

class LessonUsersUpdatePercentListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $attributes = $event->getModel()->getAttributes();

        $course_id = Courses::query()->findOrFail(Lessons::query()->findOrFail($attributes['lesson_id'])['course_id'])['id'];
        $all_lessons = Lessons::query()->where(["course_id" => $course_id])->get('id');
        $completed_lessons = LessonUsers::query()->whereIn('lesson_id', $all_lessons)->where([
            'user_id' => $attributes['user_id'],
            'is_passed' => true
        ])->count();

        CourseUsers::query()->where(['user_id' => $attributes['user_id'], 'course_id' => $course_id])
            ->update(['percentage_passing' => round(100 * $completed_lessons / count($all_lessons))]);
    }
}
