<?php

namespace App\Models;

use App\Events\LessonUsersUpdatedEvent;
use App\Events\LessonUsersUpdatingEvent;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Model as EgalModel;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $user_id {@property-type field} {@validation-rules required}
 * @property $lesson_id {@property-type field} {@validation-rules required|int}
 * @property $is_passed {@property-type field} {@validation-rules required|boolean}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action update {@roles-access user}
 */
class LessonUsers extends EgalModel
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'is_passed',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'updating' => LessonUsersUpdatingEvent::class,
        'updated' => LessonUsersUpdatedEvent::class,
    ];

    public static function getCompletedLessonsByCourseId($course_id, $user_id)
    {
        $all_lessons = Lessons::getIdsByCourseId($course_id);

        $instance = new static();
        $instance->makeIsInstanceForAction();

        $items = $instance->newQuery()
            ->makeModelIsInstanceForAction()
            ->whereIn('lesson_id', $all_lessons)->where(['user_id' => $user_id, 'is_passed' => true])->count();

        if (!$items) {
            throw ObjectNotFoundException::make($course_id);
        }

        return $items;
    }
}
