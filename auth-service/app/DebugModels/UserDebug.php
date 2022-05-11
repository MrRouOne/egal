<?php

namespace App\DebugModels;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property $id            {@property-type field}          {@primary-key}
 * @property $email         {@property-type field}          {@validation-rules string}
 * @property $password      {@property-type field}          {@validation-rules string}
 * @property $phone         {@property-type fake-field}     {@validation-rules string}
 * @property $last_name     {@property-type fake-field}     {@validation-rules string}
 * @property $first_name    {@property-type fake-field}     {@validation-rules string}
 * @property $created_at    {@property-type field}
 * @property $updated_at    {@property-type field}
 *
 * @property Collection $roles          {@property-type relation}
 * @property Collection $permissions    {@property-type relation}
 *
 * @action register                     {@statuses-access guest}
 * @action login                        {@statuses-access guest}
 * @action loginToService               {@statuses-access guest}
 * @action refreshUserMasterToken       {@statuses-access guest}
 * @action getItems                     {@statuses-access guest|logged}
 */
class UserDebug extends User
{
    protected $table = 'users';

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles','user_id', 'role_id');
    }
}
