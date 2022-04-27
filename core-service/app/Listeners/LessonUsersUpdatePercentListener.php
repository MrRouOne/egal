<?php

namespace App\Listeners;

use App\Events\CourseUsersCreatingEvent;
use App\Events\LessonUsersUpdatedEvent;
use App\Events\LessonUsersUpdatingEvent;
use App\Exceptions\AlreadyCompleteException;
use App\Exceptions\CapacityException;
use App\Exceptions\ForbiddenFieldsException;
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

class LessonUsersUpdatePercentListener
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
     * @param LessonUsersUpdatedEvent $event
     * @throws ObjectNotFoundException
     * @throws UpdateException
     */
    public function handle(LessonUsersUpdatedEvent $event): void
    {
        $attributes = $event->data->getAttributes();

        $course_id = Lessons::actionGetItem($attributes['lesson_id'], ["course"])['course']['id'];
        $all_lessons = count(Lessons::getIdsByCourseId($course_id));
        $completed_lessons = LessonUsers::getCompletedLessonsByCourseId($course_id, $attributes['user_id']);
        $id = CourseUsers::getItemByUserAndCourse($course_id, $attributes['user_id'])[0]['id'];

        CourseUsers::actionUpdate($id, ['percentage_passing' => round(100 * $completed_lessons / $all_lessons)]);
    }
}
