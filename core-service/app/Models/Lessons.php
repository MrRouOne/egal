<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $course_id {@property-type field} {@validation-rules required|int}
 * @property $theme {@property-type field} {@validation-rules required|string}
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
class Lessons extends EgalModel
{
    protected $fillable = [
        'course_id',
        'theme',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class);
    }

    public function lessons(): belongsToMany
    {
        return $this->belongsToMany(Users::class, 'lesson_users', 'lesson_id', 'user_id');
    }
}
