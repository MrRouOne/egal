<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $phone {@property-type field} {@validation-rules required|string}
 * @property $last_name {@property-type field} {@validation-rules required|string}
 * @property $first_name {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access guest|logged}
 * @action getItem {@statuses-access guest|logged}
 * @action getItems {@statuses-access guest|logged}
 * @action create {@statuses-access guest|logged}
 * @action update {@statuses-access guest|logged}
 * @action delete {@statuses-access guest|logged}
 */
class Users extends EgalModel
{
    protected $fillable = [
//        'id',
        'phone',
        'last_name',
        'first_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function courses(): belongsToMany
    {
        return $this->belongsToMany(Courses::class, 'course_users', 'user_id', 'course_id');
    }

    public function lessons(): belongsToMany
    {
        return $this->belongsToMany(Lessons::class, 'lesson_users', 'user_id', 'lesson_id');
    }
}
