<?php

namespace App\Events;

use App\Helpers\AbstractEvent;
use App\Models\CourseUsers;

class CourseUsersCreatingEvent extends AbstractEvent
{
    public function __construct(CourseUsers $data)
    {
        parent::__construct($data);
    }
}
