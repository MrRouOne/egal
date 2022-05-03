<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id {@property-type field} {@validation-rules required|uuid|unique:users,id}
 * @property $phone {@property-type field} {@validation-rules required|string}
 * @property $last_name {@property-type field} {@validation-rules required|string}
 * @property $first_name {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access logged}    {@roles-access admin}
 * @action getItem {@statuses-access logged}        {@roles-access admin}
 * @action getItems {@statuses-access logged}       {@roles-access admin}
 * @action create {@statuses-access logged}         {@services-access auth-service|auth}
 * @action update {@statuses-access logged}         {@roles-access admin}
 * @action delete {@statuses-access logged}         {@roles-access admin}
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


    /**
     * @return BelongsToMany
     */
    public function courses(): belongsToMany
    {
        return $this->belongsToMany(Courses::class, 'course_users', 'user_id', 'course_id');
    }

    /**
     * @return BelongsToMany
     */
    public function lessons(): belongsToMany
    {
        return $this->belongsToMany(Lessons::class, 'lesson_users', 'user_id', 'lesson_id');
    }
}
