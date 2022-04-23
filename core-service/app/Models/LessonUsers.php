<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $user_id {@property-type field} {@validation-rules required}
 * @property $lesson_id {@property-type field} {@validation-rules required|int}
 * @property $is_passed {@property-type field} {@validation-rules required|boolean}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@roles-access admin}
 * @action getItem {@roles-access admin}
 * @action getItems {@roles-access admin}
 * @action create {@roles-access admin}
 * @action update {@roles-access admin}
 * @action delete {@roles-access admin}
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
