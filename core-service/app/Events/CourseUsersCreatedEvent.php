<?php

namespace App\Events;

use App\Helpers\AbstractEvent;
use App\Models\CourseUsers;

class CourseUsersCreatedEvent extends AbstractEvent
{
    // необязательно декларировать
    /**
     * @param CourseUsers $data
     */
    public function __construct(CourseUsers $data)
    {
        parent::__construct($data);
    }
}
