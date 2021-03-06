<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $title {@property-type field} {@validation-rules required|string}
 * @property $student_capacity {@property-type field} {@validation-rules required|int}
 * @property $start_date {@property-type field} {@validation-rules required|date|after:yesterday}
 * @property $end_date {@property-type field} {@validation-rules required|date|after:start_date}
 * @property $has_certificate {@property-type field} {@validation-rules bool}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access logged}        {@roles-access admin}
 * @action getItem {@statuses-access logged|guest}      {@roles-access admin|user}
 * @action getItems {@statuses-access logged|guest}     {@roles-access admin|user}
 * @action create {@statuses-access logged}             {@roles-access admin}
 * @action update {@statuses-access logged}             {@roles-access admin}
 * @action delete {@statuses-access logged}             {@roles-access admin}
 */
class Courses extends EgalModel
{
    use HasFactory;

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

    /**
     * @return HasMany
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lessons::class,'course_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(Users::class, 'course_users', 'course_id','user_id');
    }

}
