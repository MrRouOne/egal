<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $user_id {@property-type field}
// * {@validation-rules required|unique:course_users,user_id,null,id,course_id}
 * @property $course_id {@property-type field} {@validation-rules required|int}
 * @property $percentage_passing {@property-type field} {@validation-rules int}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action create {@statuses-access guest}
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
}
