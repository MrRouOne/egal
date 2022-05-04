<?php

namespace App\DebugModels;

use App\Models\Users;

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

class UsersDebug extends Users
{
    protected $table = 'users';
}
