<?php

namespace App\Events;

use MrRouOne\Helpers\Session;
use App\Models\User;
use MrRouOne\Helpers\AbstractEvent;

class CreateUserEvent extends AbstractEvent
{
    public User $user;
    public array $attributes;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
        $this->attributes = Session::getAttributes();
    }
}
