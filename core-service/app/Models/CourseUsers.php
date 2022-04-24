<?php

namespace App\Models;

use App\Events\CourseUsersCreatedEvent;
use App\Events\CourseUsersCreatingEvent;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Model as EgalModel;


/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $user_id {@property-type field}
 * @property $course_id {@property-type field} {@validation-rules required|int}
 * @property $percentage_passing {@property-type field} {@validation-rules int}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action create {@statuses-access logged}         {@roles-access user}
 *
 */
class CourseUsers extends EgalModel
{
    protected $fillable = [
        'user_id',
        'course_id',
        'percentage_passing',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'creating' => CourseUsersCreatingEvent::class,
        'created' => CourseUsersCreatedEvent::class,
    ];

    public static function getItemByUserAndCourse($course_id, $user_id): array
    {
        $instance = new static();
        $instance->makeIsInstanceForAction();

        $item = $instance->newQuery()
            ->makeModelIsInstanceForAction()
            ->where(['user_id' => $user_id, 'course_id' => $course_id])->get();

        if (!$item) {
            throw ObjectNotFoundException::make($course_id);
        }

        return $item->toArray();
    }
}
