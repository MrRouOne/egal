<?php

namespace App\Models;

use AWS\CRT\HTTP\Response;
use Egal\Model\Model as EgalModel;
use Egal\Model\Traits\UsesUuidKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @property $id {@property-type field} {@validation-rules required|uuid}
 * @property $phone {@property-type field} {@validation-rules required|string}
 * @property $last_name {@property-type field} {@validation-rules required|string}
 * @property $first_name {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action test {@statuses-access guest|logged}
 * @action getMetadata {@statuses-access guest|logged}
 * @action getItem {@statuses-access guest|logged}
 * @action getItems {@statuses-access guest|logged}
 * @action create {@statuses-access guest}                  {@services-access auth}
 * @action update {@statuses-access admin}
 * @action delete {@statuses-access admin}
 */
class Users extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'phone',
        'last_name',
        'first_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;


    public function courses(): belongsToMany
    {
        return $this->belongsToMany(Courses::class, 'course_users', 'user_id', 'course_id');
    }

    public function lessons(): belongsToMany
    {
        return $this->belongsToMany(Lessons::class, 'lesson_users', 'user_id', 'lesson_id');
    }

}
