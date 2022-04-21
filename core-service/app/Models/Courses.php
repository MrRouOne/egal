<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $title {@property-type field} {@validation-rules required|string}
 * @property $student_capacity {@property-type field} {@validation-rules required|int}
 * @property $start_date {@property-type field} {@validation-rules required|date}
 * @property $end_date {@property-type field} {@validation-rules required|date}
 * @property $has_certificate {@property-type field} {@validation-rules bool}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access guest|logged}
 * @action getItem {@statuses-access guest|logged}
 * @action gg {@statuses-access guest|logged}
 * @action getItems {@statuses-access guest|logged}
 * @action create {@statuses-access guest|logged}
 * @action update {@statuses-access logged} {@permissions-access super_first_permission|super_second_permission}
 * @action delete {@statuses-access logged} {@permissions-access super_first_permission,super_second_permission}
 */
class Courses extends EgalModel
{
    protected $fillable = [
        'title',
        'student_capacity',
        'start_date',
        'end_date',
        'has_certificate',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lessons::class);
    }

    public function users(): belongsToMany
    {
        return $this->belongsToMany(Users::class, 'course_users', 'course_id','user_id');
    }

    public static function actionGg(array $attributes)
    {
        return $attributes;
    }
}
