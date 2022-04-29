<?php

namespace App\Events;

use App\Helpers\AbstractEvent;
use App\Models\CourseUsers;

class CourseUsersCreatingEvent extends AbstractEvent
{
    /**
     * @param CourseUsers $data
     */
    public function __construct(CourseUsers $data)
    {
        parent::__construct($data);
    }
}
