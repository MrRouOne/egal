<?php

namespace App\Models;

use App\Events\CreateUserEvent;
use App\Exceptions\EmptyPasswordException;
use App\Exceptions\PasswordHashException;
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

/**
 * @property $id            {@property-type field}          {@primary-key}
 * @property $email         {@property-type field}          {@validation-rules required|string|email|unique:users,email}
 * @property $password      {@property-type field}          {@validation-rules required|string}
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

    protected $dispatchesEvents = [
        'creating' => CreateUserEvent::class,
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected function password(): Attribute
    {
        return new Attribute(
            get: fn($value) => ucfirst($value),
            set: fn($value) => password_hash($value, PASSWORD_BCRYPT)
        );
    }

    /**
     * @param array $attributes
     * @return User
     * @throws EmptyPasswordException
     * @throws PasswordHashException
     */
    public static function actionRegister(array $attributes = []): User
    {
        if (!$attributes['password']) {
            throw new EmptyPasswordException();
        }
        $user = new static();
        $user->setAttribute('email', $attributes['email']);
        $user->setAttribute('phone', $attributes['phone']);
        $user->setAttribute('password', $attributes['password']);
        $user->setAttribute('last_name', $attributes['last_name']);
        $user->setAttribute('first_name', $attributes['first_name']);
        $user->save();

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws LoginException
     */
    public static function actionLogin(string $email, string $password): array
    {
        /** @var BaseUser $user */
        $user = self::query()
            ->where('email', '=', $email)
            ->first();

        if (!$user || !password_verify($password, $user->getAttribute('password'))) {
            throw new LoginException('Incorrect Email or password!');
        }

        $umt = new UserMasterToken();
        $umt->setSigningKey(config('app.service_key'));
        $umt->setAuthIdentification($user->getAuthIdentifier());

        $umrt = new UserMasterRefreshToken();
        $umrt->setSigningKey(config('app.service_key'));
        $umrt->setAuthIdentification($user->getAuthIdentifier());

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
