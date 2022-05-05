<?php

namespace App\Models;

use App\Events\CreateUserEvent;
use App\Helpers\ValidateHelper;
use App\Rules\PasswordVerifyRule;
use App\Rules\UserRule;
use Egal\Auth\Tokens\UserMasterRefreshToken;
use Egal\Auth\Tokens\UserMasterToken;
use Egal\AuthServiceDependencies\Exceptions\LoginException;
use Egal\AuthServiceDependencies\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use function PHPUnit\Framework\isNull;

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
class User extends BaseUser
{
    use HasFactory;
    use HasRelationships;

    protected $hidden = [
        'password',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'last_entry' => 'array',
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $dispatchesEvents = [
        'creating' => CreateUserEvent::class,
    ];

    /**
     * @return Attribute
     */
    protected function password(): Attribute
    {
        return new Attribute(
            set: fn($value): string => password_hash($value, PASSWORD_BCRYPT)
        );
    }

    /**
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn($value): string => date_format(date_create($value), "Y-d-m"),
        );
    }

    /**
     * @return Attribute
     */
    protected function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn($value): string => date_format(date_create($value), "Y-d-m"),
        );
    }

    public static function actionRegister(array $attributes = [])
    {
        return static::actionCreate($attributes);
    }

    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws LoginException
     */
    public static function actionLogin(string $email, string $password): array
    {
        $data = [
            "user" => self::query()
                ->where('email', '=', $email)
                ->first(),
            "password" => $password,
            "email" => $email
        ];

        ValidateHelper::validate($data, [
            "user" => new UserRule(),
            "password" => new PasswordVerifyRule,
        ]);

        $umt = new UserMasterToken();
        $umt->setSigningKey(config('app.service_key'));
        $umt->setAuthIdentification($data['user']->getAuthIdentifier());
        $count = isNull($data['user']['last_entry']) ? 0 : count($data['user']['last_entry']);
        $data['user']->setAttribute("last_entry->$count", date("Y-d-m h:m:s"));
        $data['user']->save();


        $umrt = new UserMasterRefreshToken();
        $umrt->setSigningKey(config('app.service_key'));
        $umrt->setAuthIdentification($data['user']->getAuthIdentifier());

        return [
            'user_master_token' => $umt->generateJWT(),
            'user_master_refresh_token' => $umrt->generateJWT()
        ];
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * @return HasManyDeep
     */
    public function permissions(): HasManyDeep
    {
        return $this->hasManyDeep(
            Permission::class,
            [UserRole::class, Role::class, RolePermission::class],
            ['user_id', 'id', 'role_id', 'id'],
            ['id', 'role_id', 'id', 'permission_id']
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (User $user) {
            $defaultRoles = Role::query()
                ->where('is_default', true)
                ->get();
            $user->roles()
                ->attach($defaultRoles->pluck('id'));
        });
    }

    /**
     * @return array
     */
    protected function getRoles(): array
    {
        return array_unique($this->roles->pluck('id')->toArray());
    }

    /**
     * @return array
     */
    protected function getPermissions(): array
    {
        return array_unique($this->permissions->pluck('id')->toArray());
    }

}
