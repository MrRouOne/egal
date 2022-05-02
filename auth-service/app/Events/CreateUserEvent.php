<?php

namespace App\Events;

use App\Helpers\AbstractEvent;
use App\Models\User;
use Egal\Core\Session\Session;

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
        $this->attributes = Session::getActionMessage()->getParameters()['attributes'];
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

}
