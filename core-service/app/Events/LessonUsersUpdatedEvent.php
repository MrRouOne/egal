<?php

namespace App\Events;

use MrRouOne\Helpers\AbstractEvent;
use App\Models\LessonUsers;

class LessonUsersUpdatedEvent extends AbstractEvent
{
    public function __construct(LessonUsers $data)
    {
        parent::__construct($data);
    }
}
