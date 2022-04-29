<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Events\LessonUsersUpdatedEvent;
use App\Events\LessonUsersUpdatingEvent;
use App\Exceptions\AlreadyCompleteException;
use App\Exceptions\CapacityException;
use App\Exceptions\ForbiddenFieldsException;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Models\Courses;
use App\Models\CourseUsers;
use App\Models\Lessons;
use App\Models\LessonUsers;
use App\Rules\CorrectUserIdRule;
use App\Rules\ForbiddenFieldRule;
use App\Rules\IsPassedRule;
use Egal\Core\Exceptions\RequestException;
use Egal\Core\Listeners\GlobalEventListener;
use Egal\Core\Listeners\EventListener;
use Egal\Core\Session\Session;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\UpdateException;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class LessonUsersUpdatePercentListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $attributes = $event->getModel()->getAttributes();

        $course_id = Courses::query()->find(Lessons::query()->find($attributes['lesson_id'])['course_id'])['id'];
        $all_lessons = Lessons::query()->where(["course_id" => $course_id])->get('id');
        $completed_lessons = LessonUsers::query()->whereIn('lesson_id', $all_lessons)->where([
            'user_id' => $attributes['user_id'],
            'is_passed' => true
        ])->count();

        CourseUsers::query()->where(['user_id' => $attributes['user_id'], 'course_id' => $course_id])
            ->update(['percentage_passing' => round(100 * $completed_lessons / count($all_lessons))]);
    }
}
