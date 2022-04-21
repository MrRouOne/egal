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
 * @property $name {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access guest|logged}
 * @action getItem {@statuses-access guest|logged}
 * @action getItems {@statuses-access logged} {@roles-access super_first_role|super_second_role}
 * @action create {@statuses-access logged} {@roles-access super_first_role,super_second_role}
 * @action update {@statuses-access logged} {@permissions-access super_first_permission|super_second_permission}
 * @action delete {@statuses-access logged} {@permissions-access super_first_permission,super_second_permission}
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
        return $this->belongsToMany(Users::class, 'lesson_users', 'lesson_id','user_id');
    }
}
