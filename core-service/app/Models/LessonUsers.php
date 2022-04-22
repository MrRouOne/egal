<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $user_id {@property-type field} {@validation-rules required|int}
 * @property $lesson_id {@property-type field} {@validation-rules required|int}
 * @property $is_passed {@property-type field} {@validation-rules required|boolean}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access guest|logged}
 * @action getItem {@statuses-access guest|logged}
 * @action getItems {@statuses-access guest}
 * @action create {@statuses-access guest}
 * @action update {@statuses-access guest}
 * @action delete {@statuses-access guest}
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
}
