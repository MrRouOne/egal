<?php

namespace App\Events;

use App\Helpers\AbstractEvent;
use App\Models\LessonUsers;

class LessonUsersUpdatedEvent extends AbstractEvent
{
    // необязательно декларировать
    /**
     * @param LessonUsers $data
     */
    public function __construct(LessonUsers $data)
    {
        parent::__construct($data);
    }
}
