<?php

namespace App\Models;

use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $course_id {@property-type field} {@validation-rules required|int}
 * @property $theme {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access logged}    {@roles-access admin}
 * @action getItem {@statuses-access logged|guest}  {@roles-access admin}
 * @action getItems {@statuses-access logged}       {@roles-access admin}
 * @action create {@statuses-access logged}         {@roles-access admin}       {@services-access core-service}
 * @action update {@statuses-access logged}         {@roles-access admin}
 * @action delete {@statuses-access logged}         {@roles-access admin}
 */
class Lessons extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'theme',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(Users::class, 'lesson_users', 'lesson_id', 'user_id');
    }

    /**
     * @param $id
     * @return array
     * @throws ObjectNotFoundException
     */
    public static function getIdsByCourseId($id): array
    {
        $instance = new static();
        $instance->makeIsInstanceForAction();

        $items = $instance->newQuery()
            ->makeModelIsInstanceForAction()
            ->where(["course_id" => $id])->get('id');

        if (!$items) {
            throw ObjectNotFoundException::make($id);
        }

        return $items->toArray();
    }
}
